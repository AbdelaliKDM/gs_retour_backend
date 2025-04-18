<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Trip;
use App\Models\Shipment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Shipment\ShipmentResource;
use App\Http\Resources\Shipment\ShipmentCollection;
use App\Http\Resources\Shipment\ShipmentInfoResource;
use App\Http\Resources\Shipment\PaginatedShipmentCollection;

class ShipmentController extends Controller
{

  use ApiResponse;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'truck_type_id' => 'required|exists:truck_types,id',
      'shipment_type_id' => 'required|exists:shipment_types,id',
      'starting_wilaya_id' => 'required|exists:wilayas,id',
      'arrival_wilaya_id' => 'required|exists:wilayas,id',
      'starting_point_longitude' => 'required|numeric|between:-180,180',
      'starting_point_latitude' => 'required|numeric|between:-90,90',
      'arrival_point_longitude' => 'required|numeric|between:-180,180',
      'arrival_point_latitude' => 'required|numeric|between:-90,90',
      'shipping_date' => 'required|date|after_or_equal:today',
      'waiting_hours' => 'required|integer|min:0',
      'distance' => 'required|numeric|min:0',
      'price' => 'required|numeric|min:0',
      'weight' => 'sometimes|numeric|min:0'
    ]);

    try {
      $user = auth()->user();

      $request->merge(['renter_id' => $user->id]);

      $shipment = Shipment::create($request->all());

      $shipment->statuses()->create(['name' => 'pending']);

      return $this->successResponse(data: new ShipmentResource($shipment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:shipments,id',
      'shipping_date' => 'sometimes|date|after:now',
      'waiting_hours' => 'sometimes|integer|min:0',
      'weight' => 'sometimes|numeric|min:0',
      'status' => 'sometimes|in:pending,shipped,delivered'
    ]);

    try {
      $shipment = Shipment::findOrFail($request->id);

      if (auth()->id() == $shipment->renter_id) {

        $shipment->update($request->except('status'));

      } elseif (auth()->id() == $shipment->trip?->driver_id) {

        if ($request->has('status')) {
          $shipment->updateStatus($request->status);
        }

      } else {
        throw new Exception('Not allowed',405);
      }

      return $this->successResponse(data: new ShipmentResource($shipment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(Request $request)
  {
    try {
      $shipment = Shipment::findOrFail($request->id);

      if ($shipment->renter_id != auth()->id()) {
        throw new Exception('Not allowed',405);
      }

      $shipment->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function restore(Request $request)
  {
    try {
      $shipment = Shipment::withTrashed()->findOrFail($request->id);

      if ($shipment->renter_id != auth()->id()) {
        throw new Exception('Not allowed',405);
      }

      $shipment->restore();

      return $this->successResponse(data: new ShipmentResource($shipment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'sometimes|exists:shipments,id',
      'trip_id' => 'sometimes|exists:trips,id',
      'renter_id' => 'sometimes|exists:users,id',
      'truck_type_id' => 'sometimes|exists:truck_types,id',
      'shipment_type_id' => 'sometimes|exists:shipment_types,id',
      'starting_wilaya_id' => 'sometimes|exists:wilayas,id',
      'arrival_wilaya_id' => 'sometimes|exists:wilayas,id',
      'status' => 'sometimes|in:pending,shipped,delivered',
      'has_trip' => 'sometimes|in:yes,no'
    ]);

    try {
      if ($request->has('id')) {
        $shipment = Shipment::find($request->id);

        if(auth()->id() != $shipment->renter_id && auth()->id() != $shipment->trip?->driver_id){
          throw new Exception('Not allowed',405);
        }

        return $this->successResponse(data: new ShipmentInfoResource($shipment));
      }

      if ($request->has('renter_id')) {

        $shipments = Shipment::where('renter_id', $request->renter_id);

        if(auth()->id() == $request->renter_id){
          if($request->has_trip == 'yes'){
            $shipments = $shipments->whereNotNull('trip_id');
          }

          if($request->has_trip == 'no'){
            $shipments = $shipments->whereNull('trip_id');
          }
        }else{
          $shipments = $shipments->whereNull('trip_id');
        }


      } elseif ($request->has('trip_id')) {
        $trip = Trip::find($request->trip_id);

        if(auth()->id() != $trip->driver_id){
          throw new Exception('Not allowed',405);
        }

        $shipments = Shipment::where('trip_id', $request->trip_id);
      }
      else {
        $shipments = Shipment::whereNull('trip_id');
      }


      if ($request->has('truck_type_id')) {
        $shipments = $shipments->where('truck_type_id', $request->truck_type_id);
      }

      if ($request->has('shipment_type_id')) {
        $shipments = $shipments->where('shipment_type_id', $request->shipment_type_id);
      }

      if ($request->has('starting_wilaya_id')) {
        $shipments = $shipments->where('starting_wilaya_id', $request->starting_wilaya_id);
      }

      if ($request->has('arrival_wilaya_id')) {
        $shipments = $shipments->where('arrival_wilaya_id', $request->arrival_wilaya_id);
      }

      if ($request->has('status')) {

        $shipments = $shipments->whereHas('status', function ($query) use ($request) {
          $query->where('name', $request->status);
        }) ;
      }

      if ($request->has('all')) {
        $shipments = new ShipmentCollection($shipments->latest()->get());
      } else {
        $shipments = new PaginatedShipmentCollection($shipments->latest()->paginate(10));
      }

      return $this->successResponse(data: $shipments);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

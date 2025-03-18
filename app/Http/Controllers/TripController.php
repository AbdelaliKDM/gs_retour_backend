<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Trip;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Trip\TripResource;
use App\Http\Resources\Trip\TripCollection;
use App\Http\Resources\Trip\TripInfoResource;
use App\Http\Resources\Trip\PaginatedTripCollection;

class TripController extends Controller
{
  use ApiResponse;

  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'starting_wilaya_id' => 'required|exists:wilayas,id',
      'arrival_wilaya_id' => 'required|exists:wilayas,id',
      'starting_point_longitude' => 'required|numeric|between:-180,180',
      'starting_point_latitude' => 'required|numeric|between:-90,90',
      'arrival_point_longitude' => 'required|numeric|between:-180,180',
      'arrival_point_latitude' => 'required|numeric|between:-90,90',
      'distance' => 'required|numeric|min:0',
      'starts_at' => 'required|date|after:now'
    ]);

    try {

      $user = auth()->user();

      $truck = $user?->truck;

      if (empty($truck)) {
        throw new Exception('no truck found');
      }

      $request->merge([
        'driver_id' => $user->id,
        'truck_id' => $truck->id
      ]);

      $trip = Trip::create($request->all());

      $trip->statuses()->create(['name' => 'pending']);

      return $this->successResponse(data: new TripResource($trip));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:trips,id',
      'starts_at' => 'sometimes|date|after:now',
      'status' => 'sometimes|in:pending,ongoing,canceled,paused,completed'
    ]);

    try {
      $trip = Trip::findOrFail($request->id);

      if (auth()->id() != $trip->driver_id) {
        throw new Exception('Unauthorized action.');
      }

      $trip->update($request->except('status'));

      if ($request->has('status')) {
        $trip->updateStatus($request->status);
      }

      return $this->successResponse(data: new TripResource($trip));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(Request $request)
  {
    try {
      $trip = Trip::findOrFail($request->id);

      if ($trip->driver_id != auth()->id()) {
        throw new Exception('Unauthorized action.');
      }

      $trip->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function restore(Request $request)
  {
    try {
      $trip = Trip::withTrashed()->findOrFail($request->id);

      if ($trip->driver_id != auth()->id()) {
        throw new Exception('Unauthorized action.');
      }

      $trip->restore();

      return $this->successResponse(data: new TripResource($trip));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'sometimes|exists:trips,id',
      'driver_id' => 'sometimes|exists:users,id',
      'category_id' => 'sometimes|exists:categories,id',
      'subcategory_id' => 'sometimes|exists:subcategories,id',
      'truck_type_id' => 'sometimes|exists:truck_types,id',
      'starting_wilaya_id' => 'sometimes|exists:wilayas,id',
      'arrival_wilaya_id' => 'sometimes|exists:wilayas,id',
    ]);

    try {
      if ($request->has('id')) {
        $trip = Trip::find($request->id);
        if (auth()->id() != $trip->driver_id &&
          $trip->shipments()->where('renter_id', auth()->id())->doesntExist())
        {
          throw new Exception('You do not have permission to access this trip info.');
        }
        return $this->successResponse(data: new TripInfoResource($trip));
      }

      $trips = Trip::latest();

      if ($request->driver_id != auth()->id()) {
        $trips->whereHas('status', function ($query) use ($request) {
          $query->where('name', 'pending');
        });
      }

      if ($request->has('driver_id')) {
        $trips = $trips->where('driver_id', $request->driver_id);
      }

      if ($request->has('starting_wilaya_id')) {
        $trips = $trips->where('starting_wilaya_id', $request->starting_wilaya_id);
      }

      if ($request->has('arrival_wilaya_id')) {
        $trips = $trips->where('arrival_wilaya_id', $request->arrival_wilaya_id);
      }

      if ($request->has('category_id')) {
        $trips = $trips->whereHas('truck', function ($query) use ($request) {
          $query->whereHas('truckType', function ($subQuery) use ($request) {
            $subQuery->whereHas('subcategory', function ($subSubQuery) use ($request) {
              $subSubQuery->where('category_id', $request->category_id);
            });
          });
        });
      }

      if ($request->has('subcategory_id')) {
        $trips = $trips->whereHas('truck', function ($query) use ($request) {
          $query->whereHas('truckType', function ($subQuery) use ($request) {
            $subQuery->where('subcategory_id', $request->subcategory_id);
          });
        });
      }

      if ($request->has('truck_type_id')) {
        $trips = $trips->whereHas('truck', function ($query) use ($request) {
          $query->where('truck_type_id', $request->truck_type_id);
        });
      }

      if ($request->has('all')) {
        $trips = new TripCollection($trips->get());
      } else {
        $trips = new PaginatedTripCollection($trips->paginate(10));
      }

      return $this->successResponse(data: $trips);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

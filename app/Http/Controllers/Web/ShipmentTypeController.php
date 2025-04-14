<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use App\Traits\ApiResponse;
use App\Models\ShipmentType;
use Illuminate\Http\Request;
use App\Http\Resources\ShipmentType\ShipmentTypeResource;
use App\Http\Resources\ShipmentType\ShipmentTypeCollection;
use App\Http\Resources\ShipmentType\PaginatedShipmentTypeCollection;

class ShipmentTypeController extends Controller
{
  use ApiResponse;

  public function index()
  {
    return view("content.shipmentType.index");
  }

  public function list(Request $request)
  {

    $data = ShipmentType::latest()->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

        $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("shipmentType.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("shipmentType.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        return $btn;
      })

      ->addColumn('created_at', function ($row) {

        return date('Y-m-d', strtotime($row->created_at));

      })

      ->make(true);
  }

  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'name_ar' => 'required|string',
      'name_en' => 'required|string',
      'name_fr' => 'required|string',
    ]);

    try {
      $shipment_type = ShipmentType::create($request->all());

      return $this->successResponse(data: new ShipmentTypeResource($shipment_type));
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'name_ar' => 'sometimes|string',
      'name_en' => 'sometimes|string',
      'name_fr' => 'sometimes|string',
    ]);

    try {
      $shipment_type = ShipmentType::findOrFail($request->id);

      $shipment_type->update($request->all());

      return $this->successResponse(data: new ShipmentTypeResource($shipment_type));
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required',
      'confirmed' => 'sometimes'
    ]);

    try {
      $shipment_type = ShipmentType::findOrFail($request->id);

      if ($request->has('confirmed')) {

        $shipment_type->delete();

        return $this->successResponse();

      } else {

        $shipments = $shipment_type->shipments()->count();

        $data = [];

        empty($shipments) ?: $data[__('app.shipments')] = $shipments;

        return $this->successResponse(data: $data);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function restore(Request $request)
  {
    try {
      $shipment_type = ShipmentType::withTrashed()->findOrFail($request->id);

      $shipment_type->restore();

      return $this->successResponse(data: new ShipmentTypeResource($shipment_type));
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {
    //paginated
    $this->validateRequest($request, [
      'id' => 'sometimes',
      'search' => 'sometimes|string'
    ]);

    try {
      if ($request->has('id')) {
        $shipment_type = ShipmentType::findOrFail($request->id);
        return $this->successResponse(data: $shipment_type);
      }

      $shipment_types = ShipmentType::latest();

      if ($request->has('search')) {
        $shipment_types = $shipment_types->where(function ($query) use ($request) {
          $query->where('name_ar', 'like', "%$request->search%")
            ->orWhere('name_en', 'like', "%$request->search%")
            ->orWhere('name_fr', 'like', "%$request->search%");
        });
      }

      if ($request->has('all')) {
        $shipment_types = new ShipmentTypeCollection($shipment_types->get());
      } else {
        $shipment_types = new PaginatedShipmentTypeCollection($shipment_types->paginate(10));
      }

      return $this->successResponse(data: $shipment_types);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

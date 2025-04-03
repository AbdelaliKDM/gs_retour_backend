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
      try {
        $shipment_type = ShipmentType::findOrFail($request->id);

        $shipment_type->delete();

        return $this->successResponse();
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
          return $this->successResponse(data: new ShipmentTypeResource($shipment_type));
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

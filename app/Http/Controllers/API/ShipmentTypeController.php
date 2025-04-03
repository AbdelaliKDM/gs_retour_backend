<?php

namespace App\Http\Controllers\API;

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

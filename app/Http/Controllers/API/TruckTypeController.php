<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Http\Resources\TruckType\PaginatedTruckTypeCollection;
use App\Http\Resources\TruckType\TruckTypeCollection;
use App\Models\TruckType;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\TruckType\TruckTypeResource;

class TruckTypeController extends Controller
{
  use ApiResponse;

  public function get(Request $request)
  {
    //paginated
    $this->validateRequest($request, [
      'id' => 'sometimes',
      'category_id' => 'sometimes|exists:categories,id',
      'subcategory_id' => 'sometimes|exists:subcategories,id',
      'search' => 'sometimes|string'
    ]);

    try {
      if ($request->has('id')) {
        $truck_type = TruckType::findOrFail($request->id);
        return $this->successResponse(data: new TruckTypeResource($truck_type));
      }

      $truck_types = TruckType::latest();

      if ($request->has('category_id')) {
        $truck_types = $truck_types->whereHas('subcategory', function ($query) use ($request) {
          $query->where('category_id', $request->category_id);
        });
      }

      if ($request->has('subcategory_id')) {
        $truck_types = $truck_types->where('subcategory_id', $request->subcategory_id);
      }

      if ($request->has('search')) {
        $truck_types = $truck_types->where(function ($query) use ($request) {
          $query->where('name_ar', 'like', "%$request->search%")
            ->orWhere('name_en', 'like', "%$request->search%")
            ->orWhere('name_fr', 'like', "%$request->search%");
        });
      }

      if ($request->has('all')) {
        $truck_types = new TruckTypeCollection($truck_types->get());
      } else {
        $truck_types = new PaginatedTruckTypeCollection($truck_types->paginate(10));
      }

      return $this->successResponse(data: $truck_types);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

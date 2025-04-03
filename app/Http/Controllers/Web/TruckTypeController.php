<?php

namespace App\Http\Controllers\Web;

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

  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'subcategory_id' => 'required|exists:subcategories,id',
      'name_ar' => 'required|string',
      'name_en' => 'required|string',
      'name_fr' => 'required|string',
      'weight' => 'sometimes|numeric',
      'capacity' => 'sometimes|integer'
    ]);

    try {
      $truck_type = TruckType::create($request->all());

      return $this->successResponse(data: new TruckTypeResource($truck_type));
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required',
      'subcategory_id' => 'sometimes|exists:subcategories,id',
      'name_ar' => 'sometimes|string',
      'name_en' => 'sometimes|string',
      'name_fr' => 'sometimes|string',
      'weight' => 'sometimes|numeric',
      'capacity' => 'sometimes|integer'
    ]);

    try {
      $truck_type = TruckType::findOrFail($request->id);

      $truck_type->update($request->all());

      return $this->successResponse(data: new TruckTypeResource($truck_type));
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(Request $request)
  {
    try {
      $truck_type = TruckType::findOrFail($request->id);

      $truck_type->delete();

      return $this->successResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function restore(Request $request)
  {
    try {
      $truck_type = TruckType::withTrashed()->findOrFail($request->id);

      $truck_type->restore();

      return $this->successResponse(data: new TruckTypeResource($truck_type));
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

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

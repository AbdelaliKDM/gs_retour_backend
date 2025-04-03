<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;

use App\Traits\ApiResponse;
use App\Traits\FileUpload;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\Subcategory\SubcategoryResource;
use App\Http\Resources\Subcategory\SubcategoryCollection;
use App\Http\Resources\Subcategory\PaginatedSubcategoryCollection;

class SubcategoryController extends Controller
{
  use ApiResponse, FileUpload;

  public function get(Request $request)
  {  //paginated
    $this->validateRequest($request, [
      'id' => 'sometimes',
      'category_id' => 'sometimes|exists:categories,id',
      'search' => 'sometimes|string',
    ]);

    try {

      if ($request->has('id')) {
        $subcategory = Subcategory::findOrFail($request->id);
        return $this->successResponse(data: new SubcategoryResource($subcategory));
      }

      $subcategories = Subcategory::latest();

      if ($request->has('category_id')) {
        $subcategories = $subcategories->where('category_id', $request->category_id);
      }


      if ($request->has('search')) {

        $subcategories = $subcategories->where(function ($query) use ($request) {
          $query->where('name_ar', 'like', '%' . $request->search . '%')
            ->orWhere('name_en', 'like', '%' . $request->search . '%')
            ->orWhere('name_fr', 'like', '%' . $request->search . '%');
        });
      }

      if ($request->has('all')) {
        $subcategories = new SubcategoryCollection($subcategories->get());
      } else {
        $subcategories = new PaginatedSubcategoryCollection($subcategories->paginate(10));
      }

      return $this->successResponse(data: $subcategories);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

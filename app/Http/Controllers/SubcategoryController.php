<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\FileUpload;
use Exception;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Subcategory\SubcategoryResource;
use App\Http\Resources\Subcategory\SubcategoryCollection;
use App\Http\Resources\Subcategory\PaginatedSubcategoryCollection;

class SubcategoryController extends Controller
{
  use ApiResponse, FileUpload;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'category_id' => 'required|exists:categories,id',
      'name_ar' => 'required|string',
      'name_en' => 'required|string',
      'name_fr' => 'required|string',
      'image' => 'sometimes|mimetypes:image/*'
    ]);

    try {

      $subcategory = Subcategory::create($request->except('image'));

      $subcategory->image = $this->handleFileUpload(
        $request->file('image'),
        $subcategory->image,
        '/uploads/subcategories/images'
      ) ?? $subcategory->image;

      return $this->successResponse(data: new SubcategoryResource($subcategory));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required',
      'category_id' => 'sometimes|exists:categories,id',
      'name_ar' => 'sometimes|string',
      'name_en' => 'sometimes|string',
      'name_fr' => 'sometimes|string',
      'image' => 'sometimes|mimetypes:image/*'
    ]);

    try {

      $subcategory = Subcategory::findOrFail($request->id);

      $subcategory->update($request->except('image'));

      $subcategory->image = $this->handleFileUpload(
        $request->file('image'),
        $subcategory->image,
        '/uploads/subcategories/images'
      ) ?? $subcategory->image;

      return $this->successResponse(data: new SubcategoryResource($subcategory));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function delete(Request $request)
  {

    try {

      $subcategory = Subcategory::findOrFail($request->id);

      $subcategory->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function restore(Request $request)
  {

    try {

      $subcategory = Subcategory::withTrashed()->findOrFail($request->id);

      $subcategory->restore();

      return $this->successResponse(data: new SubcategoryResource($subcategory));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

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

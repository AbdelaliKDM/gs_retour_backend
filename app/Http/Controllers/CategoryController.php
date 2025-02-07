<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\FileUpload;
use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\PaginatedCategoryCollection;
use Storage;

class CategoryController extends Controller
{

  use ApiResponse, FileUpload;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'name_ar' => 'required|string',
      'name_en' => 'required|string',
      'name_fr' => 'required|string',
      'image' => 'sometimes|mimetypes:image/*'
    ]);

    try {

      $category = Category::create($request->except('image'));

      $category->image = $this->handleFileUpload(
        $request->file('image'),
        $category->image,
        '/uploads/categories/images'
      ) ?? $category->image;

      return $this->successResponse(data: new CategoryResource($category));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required',
      'name_ar' => 'sometimes|string',
      'name_en' => 'sometimes|string',
      'name_fr' => 'sometimes|string',
      'image' => 'sometimes|mimetypes:image/*'
    ]);

    try {

      $category = Category::findOrFail($request->id);

      $category->update($request->except('image'));

      $category->image = $this->handleFileUpload(
        $request->file('image'),
        $category->image,
        '/uploads/categories/images'
      ) ?? $category->image;

      return $this->successResponse(data: new CategoryResource($category));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function delete(Request $request)
  {

    try {

      $category = Category::findOrFail($request->id);

      $category->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function restore(Request $request)
  {

    try {

      $category = Category::withTrashed()->findOrFail($request->id);

      $category->restore();

      return $this->successResponse(data: new CategoryResource($category));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function get(Request $request)
  {  //paginated
    $this->validateRequest($request, [
      'id' => 'sometimes',
      'search' => 'sometimes|string',
    ]);

    try {

      if ($request->has('id')) {
        $category = Category::findOrFail($request->id);
        return $this->successResponse(data: new CategoryResource($category));
      }

      $categories = Category::latest();


      if ($request->has('search')) {

        $categories = $categories->where(function ($query) use ($request) {
          $query->where('name_ar', 'like', '%' . $request->search . '%')
            ->orWhere('name_en', 'like', '%' . $request->search . '%')
            ->orWhere('name_fr', 'like', '%' . $request->search . '%');
        });
      }

      if ($request->has('all')) {
        $categories = new CategoryCollection($categories->get());
      } else {
        $categories = new PaginatedCategoryCollection($categories->paginate(10));
      }

      return $this->successResponse(data: $categories);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

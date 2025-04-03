<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Category;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\PaginatedCategoryCollection;

class CategoryController extends Controller
{

  use ApiResponse, FileUpload;

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

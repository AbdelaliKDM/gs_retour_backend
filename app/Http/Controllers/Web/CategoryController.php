<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Category;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryInfoResource;
use App\Http\Resources\Category\PaginatedCategoryCollection;

class CategoryController extends Controller
{

  use ApiResponse, FileUpload;
  protected $model = 'category';
  public function index()
  {
    return view("content.{$this->model}.index")->with([
      'model' => $this->model
    ]);
  }

  public function list(Request $request)
  {

    $data = Category::latest()->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

        $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("{$this->model}.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("{$this->model}.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        return $btn;
      })

      ->addColumn('image', function ($row) {

        return $row->image_url ?? 'https://placehold.co/100?text=No+Image';

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
      'image' => 'sometimes|mimetypes:image/*'
    ]);

    try {

      $category = Category::create($request->except('image'));

      $category->image = $this->handleFileUpload(
        $request->file('image'),
        $category->image,
        '/uploads/categories/images'
      ) ?? $category->image;

      $category->save();

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

      $category->save();

      return $this->successResponse(data: new CategoryResource($category));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function delete(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required',
      'confirm_delete' => 'sometimes'
    ]);

    try {

      $category = Category::findOrFail($request->id);

      if($request->has('confirm_delete')){

        $category->delete();

        return $this->successResponse();

      }else{

          $subcategories = $category->subcategories()->count();
          $truckTypes = $category->truckTypes()->count();
          $trucks = $category->trucks()->count();

          $data = [];

        empty($subcategories) ?: $data[__('app.subcategories')] = $subcategories;
        empty($truckTypes) ?: $data[__('app.truckTypes')] = $truckTypes;
        empty($trucks) ?: $data[__('app.trucks')] = $trucks;

        return $this->successResponse(data: $data);
      }



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
        return $this->successResponse(data: new CategoryInfoResource($category));
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

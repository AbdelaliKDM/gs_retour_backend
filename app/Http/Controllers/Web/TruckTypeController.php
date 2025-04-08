<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\TruckType;
use App\Models\Subcategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TruckType\TruckTypeResource;
use App\Http\Resources\TruckType\TruckTypeCollection;
use App\Http\Resources\TruckType\TruckTypeInfoResource;
use App\Http\Resources\TruckType\PaginatedTruckTypeCollection;

class TruckTypeController extends Controller
{
  use ApiResponse;

  protected $model = 'truckType';

  public function index()
  {
    return view("content.{$this->model}.index")->with([
      'model' => $this->model,
      'subcategories' => Subcategory::all()->pluck('name','id')->toArray()
    ]);
  }

  public function list(Request $request)
  {

    $data = TruckType::latest()->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

        $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("{$this->model}.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("{$this->model}.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        return $btn;
      })

      ->addColumn('subcategory', function ($row) {

        return $row->subcategory->name;

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
      'subcategory_id' => 'required|exists:subcategories,id',
      'name_ar' => 'required|string',
      'name_en' => 'required|string',
      'name_fr' => 'required|string',
      'weight' => 'sometimes|nullable|numeric',
      'capacity' => 'sometimes|nullable|integer'
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
      'weight' => 'sometimes|nullable|numeric',
      'capacity' => 'sometimes|nullable|integer'
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
    $this->validateRequest($request, [
      'id' => 'required',
      'confirmed' => 'sometimes'
    ]);

    try {
      $truck_type = TruckType::findOrFail($request->id);

      if($request->has('confirmed')){

        $truck_type->delete();

        return $this->successResponse();

      }else{


          $trucks = $truck_type->trucks()->count();


          $data = [];


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
        return $this->successResponse(data: new TruckTypeInfoResource($truck_type));
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

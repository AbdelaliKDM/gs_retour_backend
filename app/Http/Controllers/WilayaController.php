<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Exception;
use App\Models\Wilaya;
use Illuminate\Http\Request;
use App\Http\Resources\Wilaya\WilayaResource;
use App\Http\Resources\Wilaya\WilayaCollection;
use App\Http\Resources\Wilaya\PaginatedWilayaCollection;

class WilayaController extends Controller
{

  use ApiResponse;
  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'sometimes|exists:wilayas,id',
    ]);

    try {
      if ($request->has('id')) {
        $wilaya = Wilaya::findOrFail($request->id);
        return $this->successResponse(data: new WilayaResource($wilaya));
      }

      $wilayas = Wilaya::latest();


      if ($request->has('all')) {
        $wilayas = new WilayaCollection($wilayas->get());
      } else {
        $wilayas = new PaginatedWilayaCollection($wilayas->paginate(10));
      }

      return $this->successResponse(data: $wilayas);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TruckImage;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TruckImage\TruckImageResource;
use App\Http\Resources\TruckImage\TruckImageCollection;
use App\Http\Resources\TruckImage\PaginatedTruckImageCollection;

class TruckImageController extends Controller
{

  use ApiResponse, FileUpload;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'image' => 'required|mimetypes:image/*'
    ]);

    try {

      $truck = auth()->user()->truck;

      $truck_image = TruckImage::create(['truck_id' => $truck->id]);

      $truck_image->path = $this->handleFileUpload(
        $request->file('image'),
        null,
        '/uploads/trucks/images'
      );

      $truck_image->save();

      return $this->successResponse(data: new TruckImageResource($truck_image));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(Request $request)
  {

    try {

      $truck_image = TruckImage::findOrFail($request->id);

      Storage::disk('upload')->delete($truck_image->path);

      $truck_image->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function get(Request $request)
  {

    try {

      $truck_images = auth()->user()->truck->truckImages()->latest();

      if ($request->has('all')) {
        $truck_images = new TruckImageCollection($truck_images->get());
      } else {
        $truck_images = new PaginatedTruckImageCollection($truck_images->paginate(10));
      }

      return $this->successResponse(data: $truck_images);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

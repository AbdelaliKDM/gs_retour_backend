<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Exception;
use App\Models\Trip;
use App\Models\Favorite;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\Trip\TripCollection;
use App\Http\Resources\Shipment\ShipmentCollection;

class FavoriteController extends Controller
{

  use ApiResponse;
  public function toggle(Request $request)
  {
    $this->validateRequest($request, [
      'id' => ['required', Rule::exists(auth()->user()->role == 'driver' ? 'shipments' : 'trips')],
    ]);

    try {

      $data = [
        'user_id' => auth()->id(),
        'favorable_id' => $request->id,
        'favorable_type' => auth()->user()->role == 'driver' ? Shipment::class : Trip::class
      ];

      $favorite = Favorite::where($data)->first();

      if ($favorite) {
        $favorite->delete();
      } else {
        Favorite::create($data);
      }

      return $this->successResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {

    try {

      $user = auth()->user();

      if ($user->role == 'driver') {

        $shipments = Shipment::whereHas('favorites', function($query) use ($user){
          $query->where('user_id', $user->id);
        })->whereNull('trip_id')->get();

        return $this->successResponse(data: new ShipmentCollection($shipments));
      }

      if ($user->role == 'renter') {
        $trips = Trip::whereHas('favorites', function($query) use ($user){
          $query->where('user_id', $user->id);
        })->where('status', 'pending')->get();

        return $this->successResponse(data: new TripCollection($trips));

      }

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

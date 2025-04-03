<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DriverCollection;
use App\Models\User;
use App\Traits\Firebase;
use App\Traits\MiscHelper;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

  use ApiResponse, Firebase, MiscHelper;

  public function nearby(Request $request)
  {
    $this->validateRequest($request, [
      'longitude' => 'required|numeric|between:-180,180',
      'latitude' => 'required|numeric|between:-90,90',
    ]);


    $realtime_data = $this->get_realtime_data();
    $distanceCases = [];

    array_walk($realtime_data, function (&$item, $key) use ($request, &$distanceCases) {
      $distance = $this->calc_distance($item['location'], $request->all());
      $distanceCases[$key] = "WHEN id = {$key} THEN {$distance}";
    });


    $users = User::whereIn('id', array_keys($distanceCases))
      ->whereNot('id', auth()->id())
      ->where('role', 'driver')
      ->whereHas('trip')
      ->select('*', DB::raw("CASE " . implode(' ', $distanceCases) . " END as distance"))
      ->orderBy('distance')
      ->with('trip')
      ->paginate(10);

      return $this->successResponse(data: new DriverCollection($users));
  }
}

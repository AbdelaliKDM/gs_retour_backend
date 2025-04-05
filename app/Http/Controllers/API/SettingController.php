<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponse;
use App\Traits\MiscHelper;
use Illuminate\Http\Request;

class SettingController extends Controller
{
 use ApiResponse, MiscHelper;
  public function get()
  {

    $settings = Setting::pluck('value', 'name');

    return $this->successResponse(data:$settings);
  }

  public function distance_price(Request $request)
  {

    $this->validateRequest($request, [
      'distance' => 'required|numeric',
    ]);


    return $this->successResponse(data: floatval($this->calc_price($request->distance)));
  }


}

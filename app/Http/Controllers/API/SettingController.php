<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
 use ApiResponse;
  public function get()
  {

    $settings = Setting::pluck('value', 'name');

    return $this->successResponse(data:$settings);
  }


}

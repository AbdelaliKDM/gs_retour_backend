<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
 use ApiResponse;
  public function update(Request $request)
  {
    foreach ($request->all() as $key => $value) {
      Setting::updateOrInsert(['name' => $key], ['value' => $value]);
    }

    return $this->successResponse();
  }
  public function get()
  {

    $settings = Setting::pluck('value', 'name');

    return $this->successResponse(data:$settings);
  }


}

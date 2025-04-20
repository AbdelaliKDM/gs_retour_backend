<?php

namespace App\Http\Controllers\Web;

use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SuspendDriversWithMissingDocuments;

class SettingController extends Controller
{
 use ApiResponse;

 public function index()
  {
    $settings = Setting::pluck('value', 'name')->toArray();

    return view('content.settings.index')
      ->with('settings', $settings);


  }
  public function update(Request $request)
  {

    $current = Setting::required_truck_fields();

    $new = array_keys ($request->all(),'required');

    $changed = array_diff($new, $current);

    foreach ($request->all() as $key => $value) {
      Setting::updateOrInsert(['name' => $key], ['value' => $value]);
    }

    if (!empty($changed)) {
      SuspendDriversWithMissingDocuments::dispatch($changed);
    }

    return $this->successResponse();
  }
  public function get()
  {

    $settings = Setting::pluck('value', 'name');

    return $this->successResponse(data:$settings);
  }


}

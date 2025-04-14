<?php

namespace App\Http\Controllers\Web;

use App\Models\Wilaya;
use Exception;
use App\Models\Trip;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Trip\TripResource;

class TripController extends Controller
{
  use ApiResponse;

  public function index(Request $request)
  {
    return view("content.trip.index")->with([
      'status' => explode('.', $request->route()->getName())[1],
      'wilayas' => Wilaya::all()->pluck('name', 'id')->toArray()
    ]);
  }

  public function info($id)
  {
    $trip = Trip::with([
      'driver',
      'truck.truckType.subcategory.category',
      'truck.truckImages',
      'startingWilaya',
      'arrivalWilaya',
      'shipments.renter',
      'shipments.status',
      'status'
    ])->findOrFail($id);

    return view("content.trip.info")->with([
      'trip' => $trip,
    ]);
  }

  public function list(Request $request)
  {
    $data = Trip::with('driver', 'truck', 'startingWilaya', 'arrivalWilaya')
      ->whereHas('status', fn($query) => $query->where('name', $request->status))->latest();

    if ($request->starting_wilaya_id) {
      $data = $data->where('starting_wilaya_id', $request->starting_wilaya_id);
    }
    if ($request->arrival_wilaya_id) {
      $data = $data->where('arrival_wilaya_id', $request->arrival_wilaya_id);
    }

    $data = $data->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {
        $btn = '';
        $btn .= '<a href="' . url("trip/{$row->id}/info") . '" class="btn btn-icon btn-label-purple inline-spacing" title="' . __("trip.actions.info") . '"><span class="tf-icons bx bx-info-circle"></span></a>';

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("trip.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        return $btn;
      })

      ->addColumn('driver', function ($row) {

        return [
          'name' => $row->driver->name,
          'id' => $row->driver_id
        ];

      })
      ->addColumn('truck', function ($row) {
        return $row->truck_type_name;
      })
      ->addColumn('route', function ($row) {
        return $row->starting_wilaya_name . (session('locale') == 'ar' ? ' ← ' : ' → ') . $row->arrival_wilaya_name;
      })
      ->addColumn('distance', function ($row) {
        return $row->distance . __('app.km');
      })
      ->addColumn('current_status', function ($row) {
        return $row->current_status;
      })
      ->addColumn('created_at', function ($row) {
        return date('Y-m-d', strtotime($row->created_at));
      })
      ->make(true);
  }

  public function delete(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required',
      'confirmed' => 'sometimes'
    ]);

    try {

      $trip = Trip::findOrFail($request->id);

      if ($request->has('confirmed')) {

        $trip->delete();

        return $this->successResponse();

      } else {

        return $this->successResponse(data: []);
      }

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

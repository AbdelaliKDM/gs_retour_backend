<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Setting;
use App\Models\TruckImage;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Truck\TruckResource;

class TruckController extends Controller
{

  use ApiResponse, FileUpload;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      Setting::truck_parameters_validation()
    ]);

    try {
      DB::beginTransaction();

      $user = auth()->user();
      $user->update([
        'role' => 'driver',
        'status' => 'inactive'
      ]);

      $truck = $user->truck()->create([
        'user_id' => $user->id,
        'truck_type_id' => $request->truck_type_id,
        'serial_number' => $request->serial_number,
        'insurance_expiry_date' => $request->insurance_expiry_date,
        'next_inspection_date' => $request->next_inspection_date,
        'affiliated_with_agency' => $request->affiliated_with_agency,
      ]);

      $truck->gray_card = $this->handleFileUpload(
        $request->file('gray_card'),
        null,
        '/uploads/trucks/gray_cards'
      );

      $truck->driving_license = $this->handleFileUpload(
        $request->file('driving_license'),
        null,
        '/uploads/trucks/licenses'
      );

      $truck->insurance_certificate = $this->handleFileUpload(
        $request->file('insurance_certificate'),
        null,
        '/uploads/trucks/insurance'
      );

      $truck->inspection_certificate = $this->handleFileUpload(
        $request->file('inspection_certificate'),
        null,
        '/uploads/trucks/inspections'
      );


      if ($request->affiliated_with_agency) {
        $truck->agency_document = $this->handleFileUpload(
          $request->file('agency_document'),
          null,
          '/uploads/trucks/agency_documents'
        );
      }

      $truck->save();

      if ($request->has('images')) {
        $images = [];

        foreach ($request->images as $image) {
          $images[] = [
            'truck_id' => $truck->id,
            'path' => $this->handleFileUpload($image, null, '/uploads/trucks/images'),
            'created_at' => now(),
            'updated_at' => now(),
          ];
        }

        TruckImage::insert($images);
      }

      DB::commit();

      return $this->successResponse(data: new TruckResource($truck));

    } catch (Exception $e) {
      DB::rollBack();
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {

    $this->validateRequest($request, [
      'truck_type_id' => 'sometimes|exists:truck_types,id',
      'serial_number' => 'sometimes|string',
      'gray_card' => 'sometimes|file',
      'driving_license' => 'sometimes|file',
      'insurance_certificate' => 'sometimes|file',
      'insurance_expiry_date' => 'sometimes|date',
      'inspection_certificate' => 'sometimes|file',
      'next_inspection_date' => 'sometimes|date',
      'affiliated_with_agency' => 'sometimes|boolean',
      'agency_document' => 'required_if:affiliated_with_agency,true|file',
    ]);

    try {
      DB::beginTransaction();

      $user = auth()->user();

      $truck = $user->truck;

      $truck->update($request->only([
        'user_id',
        'truck_type_id',
        'serial_number',
        'insurance_expiry_date',
        'next_inspection_date',
        'affiliated_with_agency',
      ]));

      $truck->gray_card = $this->handleFileUpload(
        $request->file('gray_card'),
        $truck->gray_card,
        '/uploads/trucks/gray_cards'
      ) ?? $truck->gray_card;

      $truck->driving_license = $this->handleFileUpload(
        $request->file('driving_license'),
        $truck->driving_license,
        '/uploads/trucks/licenses'
      ) ?? $truck->driving_license;

      $truck->insurance_certificate = $this->handleFileUpload(
        $request->file('insurance_certificate'),
        $truck->insurance_certificate,
        '/uploads/trucks/insurance'
      ) ?? $truck->insurance_certificate;

      $truck->inspection_certificate = $this->handleFileUpload(
        $request->file('inspection_certificate'),
        $truck->inspection_certificate,
        '/uploads/trucks/inspections'
      ) ?? $truck->inspection_certificate;

      if ($request->affiliated_with_agency) {
        $truck->agency_document = $this->handleFileUpload(
          $request->file('agency_document'),
          $truck->agency_document,
          '/uploads/trucks/agency_documents'
        ) ?? $truck->agency_document;
      }

      $truck->save();

      DB::commit();

      return $this->successResponse(data: new TruckResource($truck));

    } catch (Exception $e) {
      DB::rollBack();
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {
    return $this->successResponse(data: new TruckResource($request->user()->truck));
  }
}

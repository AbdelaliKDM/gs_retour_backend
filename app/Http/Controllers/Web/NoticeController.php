<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Notice;
use App\Traits\Firebase;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
  use ApiResponse, Firebase;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'title_ar' => 'required|string',
      'title_en' => 'required|string',
      'title_fr' => 'required|string',
      'content_ar' => 'required|string',
      'content_en' => 'required|string',
      'content_fr' => 'required|string',
      'priority' => 'required|in:0,1'
    ]);

    try {

      $notice = Notice::create($request->all());

      return $this->successResponse(data: $notice);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:notices,id',
      'title_ar' => 'sometimes|string',
      'title_en' => 'sometimes|string',
      'title_fr' => 'sometimes|string',
      'content_ar' => 'sometimes|string',
      'content_en' => 'sometimes|string',
      'content_fr' => 'sometimes|string',
    ]);

    try {

      $notice = Notice::find($request->id);

      $notice->update($request->all());

      return $this->successResponse(data: $notice);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:notices,id',
    ]);

    try {

      $notice = Notice::find($request->id);

      $notice->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function send(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:notices,id',
    ]);

    try {

      $notice = Notice::find($request->id);

      $notice->send();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

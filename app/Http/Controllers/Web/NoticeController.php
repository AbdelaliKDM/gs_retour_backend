<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Notice;
use App\Traits\Firebase;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
  use ApiResponse, Firebase;

  protected $model = 'notice';

  public function index()
  {
    return view('content.notice.index')->with([
      'model' => $this->model
    ]);
  }

  public function list()
  {

    $data = Notice::latest()->where('type', 0)->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

        $btn .= '<button class="btn btn-icon btn-label-purple inline-spacing send" title="' . __("{$this->model}.actions.send") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-paper-plane"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("{$this->model}.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("{$this->model}.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        return $btn;
      })

      ->addColumn('title', function ($row) {

        return $row->title;

      })

      ->addColumn('priority', function ($row) {

        return $row->priority;

      })

      ->addColumn('created_at', function ($row) {

        return date('Y-m-d', strtotime($row->created_at));

      })


      ->make(true);
  }
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
      'id' => 'required',
      'confirmed' => 'sometimes'
    ]);

    try {
      $notice = Notice::findOrFail($request->id);

      if ($request->has('confirmed')) {

        $notice->delete();

        return $this->successResponse();

      } else {


        $notifications = $notice->notifications()->count();


        $data = [];


        empty($notifications) ?: $data[__('app.notifications')] = $notifications;

        return $this->successResponse(data: $data);
      }
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required',
    ]);

    try {
      $notice = Notice::findOrFail($request->id);

      return $this->successResponse(data: $notice);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function send(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:notices,id',
      "recipient_type" => "required",
      "delivery_method" => "required",
      "confirmed" => "sometimes",
    ]);

    try {

      $notice = Notice::find($request->id);

      if ($request->has('confirmed')) {

        $users = match ($request->recipient_type) {
          'all' => User::query(),
          'renters' => User::where('role', 'renter'),
          'drivers' => User::where('role', 'driver')
        };

        $with_fcm = match ($request->delivery_method) {
          'app_only' => false,
          'app_and_push' => true
        };


        $notice->send($users, $with_fcm);

      }



      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

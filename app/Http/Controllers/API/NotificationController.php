<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Traits\ApiResponse;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\Notification\NotificationCollection;
use App\Http\Resources\Notification\PaginatedNotificationCollection;

class NotificationController extends Controller
{
  use ApiResponse;
  public function read(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|integer|exists:notifications,id',
    ]);

    try {

      $notification = Notification::find($request->id);

      $notification->is_read = true;
      $notification->read_at = now();
      $notification->save();

      return $this->successResponse(data: new NotificationResource($notification));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'is_read' => 'sometimes|in:0,1',
      'type' => 'sometimes|in:0,1,2,3,4,5,6',
      'priority' => 'sometimes|in:0,1',
      'all' => 'sometimes',
    ]);

    try {

    $user = auth()->user();

      $notifications = $user->notifications()->latest();

      if ($request->has('is_read')) {
        $notifications = $notifications->where('is_read', $request->is_read);
      }

      if ($request->has('type')) {
        $notifications = $notifications->whereHas('notice', function($query) use ($request){
          $query->where('type', $request->type);
        });
      }

      if ($request->has('priority')) {
        $notifications = $notifications->whereHas('notice', function($query) use ($request){
          $query->where('priority', $request->priority);
        });
      }

      if ($request->has('all')) {
        $notifications = new NotificationCollection($notifications->get());
      } else {
        $notifications = new PaginatedNotificationCollection($notifications->paginate(10));
      }

      return $this->successResponse(data: $notifications);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

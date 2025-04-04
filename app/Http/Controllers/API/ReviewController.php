<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Trip;
use App\Models\User;
use App\Models\Notice;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\Review\ReviewResource;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\Review\PaginatedReviewCollection;

class ReviewController extends Controller
{

  use ApiResponse;
  public function create(Request $request)
  {
    $this->validateRequest($request, [
      'trip_id' => 'required|exists:trips,id',
      'rating' => 'required|numeric|min:0|max:5',
      'note' => 'sometimes|string'
    ]);

    try {
      $user = auth()->user();

      $trip = Trip::find($request->trip_id);

      if ($trip->current_status != 'completed') {
        throw new Exception('Trip is not completed');
      }

      if ($trip->shipments()->where('renter_id', auth()->id())->doesntExist()) {
        throw new Exception('You do not have delivered shipments in this trip.');
      }

      if ($trip->review()->exists()) {
        throw new Exception('You already reviewed this trip.');
      }

      $review = $user->reviews()->create($request->all());

      $notice = Notice::ReviewNotice($review->trip_id, $review->rating);

      $notice->send($review->trip->driver());

      return $this->successResponse(data: new ReviewResource($review));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:reviews,id',
      'rating' => 'sometimes|numeric|min:0|max:5',
      'note' => 'sometimes|string'
    ]);

    try {
      $user = auth()->user();

      $review = Review::find($request->id);

      if (auth()->id() != $review->user_id) {
        throw new Exception('Unauthorized action.');
      }

      $review->update($request->all());

      return $this->successResponse(data: new ReviewResource($review));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function delete(Request $request)
  {
    try {
      $review = Review::findOrFail($request->id);

      if ($review->user_id != auth()->id()) {
        throw new Exception('Unauthorized action.');
      }

      $review->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function restore(Request $request)
  {
    try {
      $review = Review::withTrashed()->findOrFail($request->id);

      if ($review->user_id != auth()->id()) {
        throw new Exception('Unauthorized action.');
      }

      $review->restore();

      return $this->successResponse(data: new ReviewResource($review));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'trip_id' => 'required|exists:trips,id',
    ]);

    try {


      $trip = Trip::find($request->trip_id);

      $user = auth()->user();



      $reviews = $trip->driver_id == $user->id
        ? new PaginatedReviewCollection($trip->reviews)
        : new ReviewResource($trip->review);


      return $this->successResponse(data: $reviews);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

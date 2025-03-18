<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Exception;
use App\Models\Trip;
use App\Models\User;
use App\Models\Review;
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

      if($trip->current_status != 'completed'){
        throw new Exception('Trip is not completed');
      }

      if($trip->shipments()->where('renter_id' , auth()->id())->doesntExist()){
        throw new Exception('You do not have delivered shipments in this trip.');
      }

      $review = $user->reviews()->create($request->all());

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

      if(auth()->id() != $review->user_id){
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

      if($review->user_id != auth()->id()){
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

      if($review->user_id != auth()->id()){
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
      'trip_id' => 'sometimes|exists:trips,id',
      'driver_id' => ['sometimes', Rule::exists('users','id')->where('role','driver')],
    ]);

    try {

      if ($request->has('trip_id')) {

       $trip = Trip::find($request->trip_id);

       $reviews = $trip->reviews();


      } elseif ($request->has('driver_id')) {
        $driver = User::find($request->driver_id);

        $reviews = $driver->trips_reviews();
      }
      else {

        $user = auth()->user();



         $reviews = $user->role == 'driver'
         ? $user->trips_reviews()
         : $user->reviews();

      }

      if ($request->has('all')) {
        $reviews = new ReviewCollection($reviews->get());
      } else {
        $reviews = new PaginatedReviewCollection($reviews->paginate(10));
      }

      return $this->successResponse(data: $reviews);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

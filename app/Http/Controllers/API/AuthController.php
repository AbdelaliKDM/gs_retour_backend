<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\User;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AuthController extends Controller
{

  use ApiResponse, FileUpload;
  public function login(Request $request)
  {

    $this->validateRequest($request, [
      'uid' => 'required',
      'device_token' => 'sometimes',
    ]);

    try {

      $firebase_user = Firebase::auth()->getUser($request->uid);

      $user = User::firstOrCreate(
        ['email' => $firebase_user->email],
        [
          'name' => $firebase_user->displayName ?? 'user#' . uuid_create(),
          'phone' => $firebase_user->phoneNumber,
          'image' => $firebase_user->photoUrl,
          'status' => 'suspended'
        ]
      )->refresh();

      if ($request->has('device_token')) {
        $user->device_token = $request->device_token;
        $user->save();
      }

      $token = $user->createToken(Str::random(8))->plainTextToken;

      return $this->successResponse(data: [
        'token' => $token,
        'user' => new UserResource($user),
      ]);

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }


  }

  public function logout(Request $request)
  {
    try {

      $request->user()->currentAccessToken()->delete();

      return $this->successResponse('Logged out.');

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

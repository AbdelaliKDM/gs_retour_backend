<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Rules\ValidPhoneNumber;
use Illuminate\Validation\Rule;
use App\Http\Resources\User\UserResource;

class AccountController extends Controller
{
    use ApiResponse, FileUpload;

    public function get(Request $request)
    {
      return $this->successResponse(data: new UserResource($request->user()));
    }

    public function update(Request $request)
    {

      $this->validateRequest($request, [
        'name' => 'sometimes|string',
        'email' => ['sometimes', 'email', Rule::unique('users')->ignore(auth()->id())],
        'phone' => ['sometimes', new ValidPhoneNumber(), Rule::unique('users')->ignore(auth()->id())],
        'image' => 'sometimes|mimetypes:image/*',
        "id_card" => 'sometimes|mimetypes:image/*',
        "id_card_selfie" => 'sometimes|mimetypes:image/*',
        "role" => 'sometimes|in:driver,renter'
      ]);

      try {

        $user = auth()->user();

        $user->update($request->only('name', 'email', 'phone'));

        if(empty($user->role) && $request->has('role')){
          $user->role = $request->role;
        }

        $user->image = $this->handleFileUpload(
          $request->file('image'),
          $user->image,
          '/uploads/users/images'
        ) ?? $user->image;

        $user->id_card = $this->handleFileUpload(
          $request->file('id_card'),
          $user->id_card,
          '/uploads/users/cards'
        ) ?? $user->id_card;

        $user->id_card_selfie = $this->handleFileUpload(
          $request->file('id_card_selfie'),
          $user->id_card_selfie,
          '/uploads/users/selfies'
        ) ?? $user->id_card_selfie;

        $user->save();

        if($request->hasAny('email','phone','id_card','id_card_selfie')){
          $user->updateStatus('inactive','profile');
        }

        return $this->successResponse(data: new UserResource($user));

      } catch (Exception $e) {
        return $this->errorResponse($e->getMessage());
      }

    }

    public function delete(Request $request)
    {

      try {

        $user = $request->user();

        $user->update([
          'email' => null,
          'phone' => null,
          'device_token' => null,
          'status' => 'deleted'
        ]);

        $user->tokens()->delete();

        $user->delete();

        return $this->successResponse();

      } catch (Exception $e) {
        return $this->errorResponse($e->getMessage());
      }

    }
}

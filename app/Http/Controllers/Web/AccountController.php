<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Rules\ValidPhoneNumber;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;

class AccountController extends Controller
{
  use ApiResponse, FileUpload;

  public function index()
  {
    return view('content.account.index');
  }

  public function update(Request $request)
  {

    $this->validateRequest($request, [
      'name' => 'sometimes|string',
      'email' => ['sometimes', 'email', Rule::unique('users')->ignore(auth()->id())],
      'phone' => ['sometimes', new ValidPhoneNumber(), Rule::unique('users')->ignore(auth()->id())],
      'image' => 'sometimes|mimetypes:image/*',
    ]);

    try {

      $user = auth()->user();

      $user->update($request->only('name', 'email', 'phone'));

      $user->image = $this->handleFileUpload(
        $request->file('image'),
        $user->image,
        '/uploads/users/images'
      ) ?? $user->image;

      $user->save();

      return $this->successResponse(data: new UserResource($user));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function change_password(Request $request)
  {

    $this->validateRequest($request, [
      'old_password' => 'required',
      'new_password' => 'required|min:8|confirmed',
    ]);


    $user = auth()->user();

    if (Hash::check($request->old_password, $user->password)) {

      $user->password = Hash::make($request->new_password);
      $user->save();

      return $this->successResponse('Password changed');

    } else {
      return $this->errorResponse('Wrong password');
    }

  }
}

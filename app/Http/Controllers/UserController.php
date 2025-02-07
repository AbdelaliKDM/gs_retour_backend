<?php

namespace App\Http\Controllers;

use App\Rules\ValidPhoneNumber;
use App\Traits\ApiResponse;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{

  use ApiResponse;
  public function index()
  {
    return view('content.users.index');
  }

  public function list()
  {

    $users = User::latest()->whereNot('id', auth()->id())->get();

    return datatables()
      ->of($users)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

        $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __('Edit') . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __('Delete') . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        return $btn;
      })

      ->addColumn('name', function ($row) {

        return $row->name;

      })


      ->addColumn('email', function ($row) {

        return $row->email;

      })

      ->addColumn('created_at', function ($row) {

        return date('Y-m-d', strtotime($row->created_at));

      })


      ->make(true);
  }

  public function create(Request $request)
  {

    $this->validateRequest($request, [
      'name' => 'required|unique:users',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6',
    ]);

    try {

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]);

      return $this->successResponse(data: new UserResource($user));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function get(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required|exists:users',
    ]);

    try {

      $user = User::find($request->id);

      return $this->successResponse(data: new UserResource($user));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
  public function update(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required|exists:users',
      'name' => 'sometimes|string',
      'email' => ['sometimes', 'email', Rule::unique('users')->ignore($request->id)],
      'phone' => ['sometimes', new ValidPhoneNumber(), Rule::unique('users')->ignore($request->id)],
      'status' => 'sometimes|in:active,suspended'
    ]);

    try {

      $user = User::find($request->id);

      $user->update($request->all());

      return $this->successResponse(data: new UserResource($user));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function delete(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required',
    ]);

    try {

      $user = User::findOrFail($request->id);

      //$user->delete();

      return $this->successResponse();

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function restore(Request $request)
  {

    $this->validateRequest($request, [
      'id' => 'required',
    ]);

    try {

      $user = User::withTrashed()->findOrFail($request->id);

      $user->restore();

      return $this->successResponse(data: new UserResource($user));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }
}

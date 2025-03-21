<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\DriverCollection;
use Exception;
use App\Models\User;
use App\Traits\Firebase;
use App\Traits\MiscHelper;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Rules\ValidPhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{

  use ApiResponse, Firebase, MiscHelper;
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

  public function nearby(Request $request)
  {
    $this->validateRequest($request, [
      'longitude' => 'required|numeric|between:-180,180',
      'latitude' => 'required|numeric|between:-90,90',
    ]);


    $realtime_data = $this->get_realtime_data();
    $distanceCases = [];

    array_walk($realtime_data, function (&$item, $key) use ($request, &$distanceCases) {
      $distance = $this->calc_distance($item['location'], $request->all());
      $distanceCases[$key] = "WHEN id = {$key} THEN {$distance}";
    });


    $users = User::whereIn('id', array_keys($distanceCases))
      //->whereHas('trip')
      ->select('*', DB::raw("CASE " . implode(' ', $distanceCases) . " END as distance"))
      ->orderBy('distance')
      ->with('trip')
      ->paginate(10);

      return $this->successResponse(data: new DriverCollection($users));
  }
}

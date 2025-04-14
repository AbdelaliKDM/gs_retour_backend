<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Traits\Firebase;
use App\Traits\MiscHelper;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Rules\ValidPhoneNumber;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use Rakit\Validation\Rules\Lowercase;

class UserController extends Controller
{

  protected $model = 'user';

  use ApiResponse, Firebase, MiscHelper;
  public function index(Request $request)
  {
    return view("content.user.index")->with([
      'role' => explode('.',$request->route()->getName())[1]
    ]);
  }

  public function info($id)
  {
    $user = User::findOrFail($id);
    $payments = $user->wallet?->payments()->latest()->paginate(10, ['*'], 'wallet_page');
    $invoices = $user->invoices()->latest()->paginate(10, ['*'], 'invoice_page');
    return view("content.user.info")->with([
      'user' => $user,
      'payments'=> $payments,
      'invoices'=> $invoices
    ]);
  }

  public function list(Request $request)
  {

    $data = User::latest()->whereNot('id', auth()->id());

    if(in_array($request->role, ['renter','driver','admin'])){
      $data = $data->where('role', $request->role);
    }else{
      $data = $data->whereNull('role');
    }

    $data = $data->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

/*         $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("user.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>';  */

        /* $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("user.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>'; */

        $btn .= '<a href="' . url("user/{$row->id}/info") . '" class="btn btn-icon btn-label-purple inline-spacing" title="' . __("user.actions.info") . '"><span class="tf-icons bx bx-info-circle"></span></a>';

        if ($row->status == 'active') {
          $btn .= '<button class="btn btn-icon btn-label-warning inline-spacing reject" title="' . __("user.actions.suspend") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-x-circle"></span></button>';
        } else {
          $btn .= '<button class="btn btn-icon btn-label-teal inline-spacing accept" title="' . __("user.actions.activate") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-check-circle"></span></button>';
        }

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
      'status' => 'sometimes|in:active,suspended',
      'suspended_for' => 'sometimes|in:admin,invoice,profile,truck',
    ]);

    try {

      $user = User::find($request->id);

      $user->update($request->only('name','email','phone'));

      if($request->has('status')){
        if($request->has('confirmed')){
          $user->updateStatus($request->status, $request->suspended_for);
        }

      }

      return $this->successResponse(data: new UserResource($user));

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

      $user = User::findOrFail($request->id);

      if($request->has('confirmed')){

        $user->update([
          'email' => null,
          'phone' => null,
          'device_token' => null,
          'status' => 'deleted'
        ]);

        $user->tokens()->delete();

        $user->delete();

        return $this->successResponse();
      }else{

        $trucks = $user->truck()->count();
        $trips = $user->trips()->count();
        $shipments = $user->shipments()->count();
        $invoices = $user->invoices()->count();
        $invoice_payments = $user->invoice_payments()->count();
        $wallet_payments = $user->wallet_payments()->count();

        $data = [];


        empty($trucks) ?: $data[__('app.trucks')] = $trucks;
        empty($trips) ?: $data[__('app.trips')] = $trips;
        empty($shipments) ?: $data[__('app.shipments')] = $shipments;
        empty($invoices) ?: $data[__('app.invoices')] = $invoices;
        empty($invoice_payments) ?: $data[__('app.invoice_payments')] = $invoice_payments;
        empty($wallet_payments) ?: $data[__('app.wallet_payments')] = $wallet_payments;


      return $this->successResponse(data: $data);
    }

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

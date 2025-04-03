<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Http\Resources\Payment\PaymentResource;
use App\Traits\FileUpload;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
  use ApiResponse, FileUpload;
  public function get(Request $request)
  {
    return $this->successResponse(data: ['balance' => auth()->user()->balance]);
  }

  public function charge(Request $request)
  {
    $this->validateRequest($request, [
      'amount' => 'required|numeric|gt:0',
      'payment_method' => 'required|in:chargily,ccp,baridi',
      'account' => [Rule::requiredIf(in_array($request->payment_method, ['ccp', 'baridi'])), 'string'],
      'receipt' => [Rule::requiredIf(in_array($request->payment_method, ['ccp', 'baridi'])), 'file', 'mimes:jpeg,png,jpg,pdf'],
    ]);

    try {

      $user = auth()->user();

      $wallet = $user->wallet;

      $payment = $wallet->payments()->create([
        'amount' => $request->amount,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
        'account' => $request->account,
      ]);

      if ($request->receipt) {
        $payment->receipt = $this->handleFileUpload(
          $request->file('receipt'),
          null,
          '/uploads/payments/wallets'
        );
      }

      $payment->save();


      return $this->successResponse(data: new PaymentResource($payment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Payment\PaymentResource;

class PaymentController extends Controller
{
  use ApiResponse;

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:payments,id',
      'status' => 'sometimes|in:failed,paid'
    ]);

    try {
      $payment = Payment::findOrFail($request->id);

      if($payment->payment_method == 'wallet'){
        throw new Exception('The payment method is wallet.');
      }

      if ($request->has('status')) {
        $payment->updateStatus($request->status);
      }

      return $this->successResponse(data: new PaymentResource($payment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

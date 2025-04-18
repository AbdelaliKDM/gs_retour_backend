<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Invoice;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Resources\Invoice\PaginatedInvoiceCollection;

class InvoiceController extends Controller
{

  use ApiResponse;
  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'year' => 'sometimes|numeric',
    ]);

    try {

      $invoices = auth()->user()->invoices();

      if ($request->has('year')) {
        $invoices = $invoices->whereYear('month', $request->year);
      }

      $invoices = $invoices->paginate(10);

      return $this->successResponse(data: new PaginatedInvoiceCollection($invoices));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function pay(Request $request){
    $this->validateRequest($request, [
        'id' => 'required|exists:invoices,id',
        'payment_method' => 'required|in:wallet,chargily,ccp,baridi',
        'account' => [Rule::requiredIf(in_array($request->payment_method, ['ccp','baridi'])),'string'],
        'receipt' => [Rule::requiredIf(in_array($request->payment_method, ['ccp','baridi'])), 'file','mimes:jpeg,png,jpg,pdf'],
    ]);

    try {

      $user = auth()->user();

      $invoice = Invoice::find($request->id);

      if($invoice->status != 'unpaid'){
        throw new Exception("The invoice status is not unpaid.");
      }

      $payment = $invoice->payments()->create([
        'amount' => $invoice->tax_amount,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
        'account' => $request->account,
    ]);

      if ($request->receipt) {
        $payment->receipt = $this->handleFileUpload(
          $request->file('receipt'),
          null,
          '/uploads/payments/invoices'
        );
        $payment->save();

      }

    if($request->payment_method == 'wallet'){
      $wallet = $user->wallet;
      if($wallet->balance >= $payment->amount){
        $payment->status = 'paid';
        $wallet->balance -= $payment->amount;
        $payment->save();
        $wallet->save();
      }else{
        $payment->status = 'failed';
        $payment->save();
        throw new Exception('Unsufficiant balance.');
      }
    }

      return $this->successResponse(data:new PaymentResource($payment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Transaction;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Transaction\PaginatedTransactionCollection;

class TransactionController extends Controller
{

  use ApiResponse;
  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'invoice_id' => 'sometimes|exists:invoices,id',
    ]);

    try {

      $transactions = Transaction::latest();

      if ($request->has('invoice_id')) {
        $transactions = $transactions->where('invoice_id', $request->invoice_id);
      }

      $transactions = $transactions->paginate(10);

      return $this->successResponse(data: new PaginatedTransactionCollection($transactions));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

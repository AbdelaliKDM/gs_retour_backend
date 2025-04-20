<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Wallet;
use App\Models\Invoice;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Resources\Payment\PaymentInfoResource;

class PaymentController extends Controller
{
  use ApiResponse;


  public function index(Request $request)
  {
    return view("content.payment.index")->with([
      'type' => explode('.', $request->route()->getName())[1]
    ]);
  }

  public function info($id)
  {
    $payment = Payment::with('payable', 'payable.user')->findOrFail($id);

    return view("content.payment.info")->with([
      'payment' => $payment,
    ]);
  }

  public function list(Request $request)
  {

    $data = Payment::orderBy('status', 'ASC')->orderBy('updated_at', 'DESC');

    //dd($data->get());
    $type = match ($request->type) {
      'wallet' => Wallet::class,
      'invoice' => Invoice::class,
      default => null
    };

    $data = $data->where('payable_type', $type)->get();

    return datatables()
      ->of($data)
      ->addIndexColumn()

      ->addColumn('action', function ($row) {
        $btn = '';

        /* $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("payment.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>'; */

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("payment.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        $btn .= '<a href="' . url("payment/{$row->id}/info") . '" class="btn btn-icon btn-label-purple inline-spacing" title="' . __("payment.actions.info") . '"><span class="tf-icons bx bx-info-circle"></span></a>';

        if ($row->status == 'pending') {
          $btn .= '<button class="btn btn-icon btn-label-warning inline-spacing reject" title="' . __("payment.actions.reject") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-x-circle"></span></button>';

          $btn .= '<button class="btn btn-icon btn-label-teal inline-spacing accept" title="' . __("payment.actions.accept") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-check-circle"></span></button>';
        }

        return $btn;
      })

      ->addColumn('user', function ($row) {

        return [
          'name' => $row->payable->user->name,
          'id' => $row->payable->user_id
        ];

      })

      ->addColumn('type', function ($row) {

        return $row->type;

      })

      ->addColumn('amount', function ($row) {

        return number_format($row->amount) . __('app.currencies.dzd');

      })

      ->addColumn('created_at', function ($row) {

        return date('Y-m-d', strtotime($row->created_at));

      })


      ->make(true);
  }

  public function update(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:payments,id',
      'status' => 'sometimes|in:failed,paid'
    ]);

    try {
      $payment = Payment::findOrFail($request->id);
      $user = $payment->payable->user;

      if ($payment->payment_method == 'wallet') {
        throw new Exception('The payment method is wallet.', 406);
      }

      if ($request->has('status')) {
        if ($request->has('confirmed')) {
          $payment->updateStatus($request->status);

          if ($payment->type == 'invoice') {
            $user->updateStatus(
              $payment->status == 'paid' ? 'active' : 'suspended',
              $payment->status == 'paid' ? null : 'invoice'
            );
          }
        }
      }

      return $this->successResponse(data: new PaymentResource($payment));

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

      $payment = Payment::findOrFail($request->id);

      if ($request->has('confirmed')) {

        $payment->delete();

        return $this->successResponse();

      } else {

        return $this->successResponse(data: []);
      }

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }

  }

  public function get(Request $request)
  {
    $this->validateRequest($request, [
      'id' => 'required|exists:payments,id',
    ]);

    try {
      $payment = Payment::findOrFail($request->id);

      return $this->successResponse(data: new PaymentInfoResource($payment));

    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}

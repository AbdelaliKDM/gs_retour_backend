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

  protected $model = 'payment';

  public function index(Request $request)
  {
    return view("content.{$this->model}.index")->with([
      'model' => $this->model,
      'type' => explode('.',$request->route()->getName())[1]
    ]);
  }

  public function list(Request $request)
  {

    $data = Payment::latest();


    $type = match($request->type){
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

        /* $btn .= '<button class="btn btn-icon btn-label-info inline-spacing update" title="' . __("{$this->model}.actions.update") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-edit"></span></button>'; */

        $btn .= '<button class="btn btn-icon btn-label-danger inline-spacing delete" title="' . __("{$this->model}.actions.delete") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-trash"></span></button>';

        $btn .= '<button class="btn btn-icon btn-label-purple inline-spacing info" title="' . __("{$this->model}.actions.info") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-info-circle"></span></button>';

        if ($row->status == 'pending') {
          $btn .= '<button class="btn btn-icon btn-label-warning inline-spacing reject" title="' . __("{$this->model}.actions.reject") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-x-circle"></span></button>';

          $btn .= '<button class="btn btn-icon btn-label-teal inline-spacing accept" title="' . __("{$this->model}.actions.accept") . '" data-id="' . $row->id . '"><span class="tf-icons bx bx-check-circle"></span></button>';
        }

        return $btn;
      })

      ->addColumn('user', function ($row) {

        return $row->payable->user->name;

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

      if($payment->payment_method == 'wallet'){
        throw new Exception('The payment method is wallet.');
      }

      if ($request->has('status')) {
        if($request->has('confirmed')){
          $payment->updateStatus($request->status);
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

      if($request->has('confirmed')){

        $payment->delete();

        return $this->successResponse();

      }else{

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

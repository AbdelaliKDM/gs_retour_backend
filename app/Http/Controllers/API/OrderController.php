<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Trip;
use App\Models\Order;
use App\Models\Notice;
use App\Models\Shipment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderCollection;

class OrderController extends Controller
{
    use ApiResponse;

    public function create(Request $request)
    {
      $this->validateRequest($request, [
        'shipment_id' => 'required|exists:shipments,id',
        'trip_id' => 'required|exists:trips,id',
      ]);

      try {

        $shipment = Shipment::findOrFail($request->shipment_id);
        $trip = Trip::findOrFail($request->trip_id);

        $isRenter = auth()->id() == $shipment->renter_id;
        $isDriver = auth()->id() == $trip->driver_id;

        if (!$isRenter && !$isDriver) {
          throw new Exception('Not allowed',405);
        }

        if ($shipment->trip_id) {
          throw new Exception('Shipment already have a trip.');
        }

        if (Order::where($request->all())->exists()) {
          throw new Exception('Order already exists.');
        }

        $order = Order::create($request->all());

        $notice = Notice::OrderNotice($order, $order->receiver, 'created');

        $notice->send($order->receiver);

        return $this->successResponse();
      } catch (Exception $e) {
        return $this->errorResponse($e->getMessage());
      }
    }

    public function update(Request $request)
    {
      $this->validateRequest($request, [
        'id' => 'required|exists:orders,id',
        'status' => 'sometimes|in:accepted,rejected',
      ]);

      try {
        $order = Order::findOrFail($request->id);

        if($request->has('status')){
          $order->updateStatus($request->status);
        }

        return $this->successResponse();
      } catch (Exception $e) {
        return $this->errorResponse($e->getMessage());
      }
    }

    public function delete(Request $request)
    {
      $this->validateRequest($request, [
        'id' => 'required|exists:orders,id',
      ]);

      try {
        $order = Order::findOrFail($request->id);

        $shipment = $order->shipment;
        $trip = $order->trip;

        $isRenter = auth()->id() === $shipment->renter_id;
        $isDriver = auth()->id() === $trip->driver_id;

        if (!$isRenter && !$isDriver) {
          throw new Exception('Not allowed',405);
        }

        if (auth()->id() != $order->created_by) {
          throw new Exception('Prohibited action.');
        }

        if ($order->status != 'pending') {
          throw new Exception('Prohibited action.');
        }


        $order->delete();

        return $this->successResponse();
      } catch (Exception $e) {
        return $this->errorResponse($e->getMessage());
      }
    }

    public function get(Request $request)
    {
      $this->validateRequest($request, [
        'shipment_id' => 'required_without:trip_id|exists:shipments,id',
        'trip_id' => 'required_without:shipment_id|exists:trips,id',
        'type' => 'sometimes|in:incoming,outgoing',
        'status' => 'sometimes|in:pending,accepted,rejected'
      ]);

      try {

        if($request->has('shipment_id')){
          $shipment = Shipment::find($request->shipment_id);

          if ($shipment->renter_id != auth()->id()) {
            throw new Exception('Not allowed',405);
          }



          $orders = match($request->type){
            'incoming' => $shipment->incoming_orders(),
            'outgoing' => $shipment->outgoing_orders(),
            default => $shipment->orders()
          };

        }

        if($request->has('trip_id')){
          $trip = Trip::find($request->trip_id);

          if ($trip->driver_id != auth()->id()) {
            throw new Exception('Not allowed',405);
          }

          $orders = match($request->type){
            'incoming' => $trip->incoming_orders(),
            'outgoing' => $trip->outgoing_orders(),
            default => $trip->orders()
          };

        }

        if ($request->has('status')) {
          $orders = $orders->where('status', $request->status);
        }

        $orders = $orders->with(['trip','shipment'])->latest()->get();


        return $this->successResponse(data: new OrderCollection($orders));

      } catch (Exception $e) {
        return $this->errorResponse($e->getMessage());
      }
    }
}

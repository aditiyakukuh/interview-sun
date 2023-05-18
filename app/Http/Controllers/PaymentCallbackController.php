<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Midtrans\CallbackService;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $callback = new CallbackService;
   
        if ($callback->isSignatureKeyVerified()) {
            $order = $callback->getOrder();

            if ($callback->isPending()) {
                $this->updateOrder($request, $order);
            }

            if ($callback->isSuccess()) {
                $this->updateOrder($request, $order);
            }
 
            if ($callback->isExpire()) {
                $this->updateOrder($request, $order);
            }
 
            if ($callback->isCancelled()) {
                $this->updateOrder($request, $order);
            }
 
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification Process Successfully',
                    'status' => $request->transaction_status
                ]);
        }else {
            return response()->json([
                'error' => true,
                'message' => 'signature key is unverified',
            ], 403);
        }
    }
    public function updateOrder($request, $order)
    {
        Order::where('id', $order->id)->update([
            'status' => $request->transaction_status,
            'payment_code' => $request->payment_code,
            'payment_type' => $request->payment_type,
            'transaction_id' => $request->transaction_id,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($id)
    {
        $order = Order::where('id', $id)->with(['user', 'item'])->first();
        $data = $this->_handleCart($order);
        $customer = $this->_handleCustomer($order->user);
        $payment = new CreateSnapTokenService($data, $customer);

        if ($order->snap_token == null) {
            $snapToken = $payment->getSnapToken();

            $order->addSnapToken($snapToken);
        }else {
            $snapToken = $order->snap_token;
        }
        
        return view('payment.payment', compact('snapToken', 'order'));
    }

    public function _handleCart($order)
    {
        $items = array();
        foreach ($order['item'] as $value) {
            $array = [
                "id" => $value['id'],
                "price" => $value['price'],
                "quantity" => $value['qty'],
                "name" => $value['product_name']
            ];
            array_push($items, $array);
        }
        
        return [
            "order_id" => $order->order_id,
            "products" => $items,
            "total_amount" => $order->getTotalAmount()
        ];
    }

    public function _handleCustomer($user)
    {
        return [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];
    }
}

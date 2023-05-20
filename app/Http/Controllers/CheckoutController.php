<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($shipping_cost)
    {
        $cart = Cart::where('user_id', 1)->first();
        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_id' => rand(),
                'status' => 'created',
                'total_amount' => $cart->getTotalAmount() + $shipping_cost,
                'user_id' => 1
            ]);
            foreach ($cart->item as $cart_item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $cart_item->product_name,
                    'price' => $cart_item->price,
                    'qty' => $cart_item->qty,
                ]);
            }
            $cart->item->each->delete();
            $cart->delete();
            DB::commit();
            return redirect()->route('orders');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}

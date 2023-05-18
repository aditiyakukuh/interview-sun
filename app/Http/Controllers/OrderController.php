<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::OrderBy('id', 'desc')->get();

        return view('payment.order', compact('orders'));
    }
}

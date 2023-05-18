<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['user', 'item'])->first();
        
        return view('payment.cart2', compact('cart'));
    }

    public function updateQty($id, Request $request)
    {
        $cart_item = CartItem::findOrFail($id);
        $cart_item->update([
            'qty' => $request->qty
        ]);
        return response()->json([
            'message' => 'cart updated',
            'data' => $cart_item
        ], 200);
    }

    public function getNewTotal()
    {
        $cart = Cart::where('user_id', 1)->first();

        return response()->json([
            'message' => 'success',
            'total_amount' => $cart->getTotalAmount(),
            'total_item' => $cart->getTotalItem()
        ], 200);
    }

    public function addCart($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $cart = $this->_getCartUser();
            $this->_addCartItem($product, $cart);
        DB::commit();
            return response()->json([
                'message' => 'add cart successfully',
                'status' => 200,
                'totalCart' => count(Cart::where('user_id', 1)->first()->item)
            ], 200);
        } catch (\Exception $e) {
        DB::rollBack();
            return response()->json($e->getMessage(), 400);
        }
    }

    public function deleteCart($id)
    {
        try {
            CartItem::findOrFail($id)->delete();
            return response()->json([
                "message" => "delete successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 402);
        }
    }

    public function _getCartUser()
    {
        $cart = Cart::where('user_id', 1)->first();
        if (!isset($cart)) {
            $cart = Cart::create([
                'user_id' => 1
            ]);
        }
        return $cart;
    }

    public function _addCartItem($product, $cart)
    {
        $cart_item = CartItem::where('product_id', $product->id)->first();
        if (!isset($cart_item)) {
            $cart_item = CartItem::create([
                'product_name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'cart_id' => $cart->id,
                'product_id' => $product->id
            ]);
        }else {
            $cart_item->update([
                'qty' => $cart_item->qty + 1
            ]);
        }
        return $cart_item;
    }
}

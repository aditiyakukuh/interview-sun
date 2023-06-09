<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\RajaOngkirRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private $rajaOngkirRepo;
    public function __construct(RajaOngkirRepo $rajaOngkirRepo)
    {
        $this->rajaOngkirRepo = $rajaOngkirRepo;
    }

    public function index()
    {
        $cities = $this->rajaOngkirRepo->getAllCity();
        $cities = $cities['results'];

        $cart = Cart::with(['user', 'item'])->first();
        
        return view('payment.cart2', compact('cart', 'cities'));
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

    public function shippingCost($city_id)
    {
        $from_city_id = 114;
        $jne_price = $this->rajaOngkirRepo->getCostJne($from_city_id, $city_id);
        $tiki_price = $this->rajaOngkirRepo->getCostTiki($from_city_id, $city_id);
        $pos_price = $this->rajaOngkirRepo->getCostPos($from_city_id, $city_id);
        return [
            [
                'text' => 'J&T Express (J&T)- Rp.'.$jne_price,
                'price' => $jne_price
            ],
            [
                'text' => 'Citra Van Titipan Kilat (TIKI)- Rp.'.$tiki_price,
                'price' => $tiki_price
            ],
            [
                'text' => 'POS Indonesia (POS)- Rp.'.$pos_price,
                'price' => $pos_price
            ],
        ];
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

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use App\Models\Pizza;
use App\Models\PizzaSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pizzaId'  => 'required|integer',
            'size'     => 'required',
            'quantity' => 'required|integer|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $cart = Cart::where('user_id', auth()->id())->where('pizza_id', $request->pizzaId)->where('size', $request->size['size'])->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->total = $cart->price * $cart->quantity;
            $cart->save();
        } else {
            $cart           = new Cart();
            $cart->user_id  = auth()->id();
            $cart->pizza_id = $request->pizzaId;
            $cart->quantity = $request->quantity;
            $cart->size     = $request->size['size'];
            $cart->price    = $request->size['price'];
            $cart->total    = $request->quantity * $request->size['price'];
        }

        $cart->save();
        return response()->json(['success' => 'Pizza added to cart']);
    }

    public function cart()
    {
        $pageTitle = 'My Cart';
        $carts     = Cart::where('user_id', auth()->id())->with('pizza')->orderBy('id', 'asc')->get();
        $subtotal = Cart::subtotal();

        return view($this->activeTemplate . 'cart', compact('pageTitle', 'carts','subtotal'));
    }

    public function updateCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id'  => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        
        $cart  = Cart::where('id', $request->cart_id)->where('user_id', auth()->id())->firstOrFail();
        $cart->quantity = $request->quantity;
        $cart->total = $cart->price * $request->quantity;
        $cart->save();
        
        session()->forget('coupon');
        return response()->json(['success' => 'Cart updated successfully.']);
    }

    public function deleteCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        Cart::where('user_id', auth()->id())->where('id', $request->cart_id)->delete();

        return response()->json(['success' => 'Pizza removed successfully']);
    }
}

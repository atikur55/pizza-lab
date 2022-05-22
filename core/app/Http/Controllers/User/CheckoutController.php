<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pizza;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $pageTitle = 'Checkout';
        $total     = session()->get('coupon');
        $user_id   = auth()->user()->id;
        $subtotal = Cart::subtotal();
        $countries      = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $shippingMethod = ShippingMethod::where('status', 1)->get();

        $coupon = null;
        if (session()->get('coupon')) {
            $coupon = session()->get('coupon');
        }


        return view($this->activeTemplate . 'checkout', compact('pageTitle', 'subtotal', 'countries', 'shippingMethod', 'coupon'));
    }

    public function order(Request $request)
    {
        $request->validate([
            'address'         => 'required',
            'shipping_method' => 'required|integer',
            'payment_type'    => 'required|integer|in:1,2',
        ]);

        $user       = auth()->user();
        $subtotal   = Cart::subtotal();
        $shipping   = ShippingMethod::where('id', $request->shipping_method)->where('status', 1)->first();

        if (!$shipping) {
            $notify[] = ['error', 'Shipping method does not exist'];
            return back()->withNotify($notify)->withInput();
        }

        $grandTotal = $subtotal + $shipping->price;
        $coupon     = session()->get('coupon');

        if ($coupon) {
            $couponId   = $coupon['coupon_id'];
            $coupon     = Coupon::where('id', $couponId)->first();

            if (!$coupon) {
                $notify[] = ['error', 'The coupon does not exist'];
                return back()->withNotify($notify)->withInput();
            }

            $discount   = discountAmount($subtotal, $coupon);
            $grandTotal = $grandTotal - $discount;
        }

        $order                  = new Order();
        $order->user_id         = $user->id;
        $order->order_no        = getTrx();
        $order->subtotal        = $subtotal;
        $order->discount        = $discount ?? 0;
        $order->shipping_charge = $shipping->price;
        $order->total           = $grandTotal;
        $order->coupon_id       = $couponId ?? 0;
        $order->coupon_code     = @$coupon->code;
        $order->address         = $request->address;
        $order->payment_status  = $request->payment_type == 2 ? 2 : 0;
        $order->status          = $request->payment_type == 2 ? 2 : 0;
        $order->save();

        session()->forget('coupon');

        $carts      = Cart::where('user_id', $user->id)->get();
        $general    = GeneralSetting::first();

        foreach ($carts as $cart) {
            $pizza = Pizza::active()->where('id', $cart->pizza_id)->with(['pizzaSize' => function ($query) use ($cart) {
                $query->where('pizza_id', $cart->pizza_id)->where('size', $cart->size);
            }])->firstOrFail();

            $orderDetail             = new OrderDetail();
            $orderDetail->order_id   = $order->id;
            $orderDetail->pizza_id   = $cart->pizza_id;
            $orderDetail->size       = $cart->size;
            $orderDetail->quantity   = $cart->quantity;
            $orderDetail->price      = $pizza->pizzaSize[0]->price;
            $orderDetail->save();
            $cart->delete();
        }

        if ($request->payment_type == 1) {
            session()->put('order_id', $order->id);
            return to_route('user.deposit');
        }

        $data                  = new Deposit();
        $data->user_id         = $user->id;
        $data->order_id        = $order->id;
        $data->method_code     = 0;
        $data->amount          = $order->total;
        $data->charge          = 0;
        $data->trx             = $order->order_no;
        $data->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'Order successfully done via Cash on delivery.';
        $adminNotification->click_url = urlPath('admin.orders.detail', $order->id);
        $adminNotification->save();

        notify($user, 'ORDER_COMPLETE', [
            'method_name'     => 'Order successfully done via Cash on delivery.',
            'user_name'       => $user->username,
            'subtotal'        => showAmount($subtotal),
            'shipping_charge' => showAmount($shipping->price),
            'discount'        => showAmount($order->discount),
            'total'           => showAmount($grandTotal),
            'currency'        => $general->cur_text,
            'order_no'        => $order->order_no,
        ]);

        $notify[] = ['success', 'Order successfully completed.'];
        return redirect()->route('user.order.history')->withNotify($notify);
    }

    public function applyCoupon(Request $request)
    {
        if (session('coupon')) {
            return response()->json(['error' => 'A coupon has already been applied. Please remove previous coupon to apply a new coupon.']);
        }

        $coupon = Coupon::active()->where('code', $request->coupon)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code provided']);
        }

        $subtotal = Cart::subtotal();

        $general = GeneralSetting::first();

        if ($coupon->min_order > $subtotal) {
            return response()->json(['error' => 'Sorry, you have to order a minimum amount of ' . $general->cur_sym . showAmount($coupon->min_order)]);
        }

        $discount = discountAmount($subtotal, $coupon);

        $coupon = [
            'coupon_id'     => $coupon->id,
            'code'          => $coupon->code,
            'discount'      => $discount,
        ];

        session()->put('coupon', $coupon);

        return response()->json([
            'success'   => 'Coupon applied successfully',
            'coupon'    => $coupon
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return response()->json(['success' => 'Coupon removed successfully']);
    }
}

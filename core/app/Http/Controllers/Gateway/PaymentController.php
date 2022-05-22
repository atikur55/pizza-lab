<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Cart;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function deposit()
    {
        $orderId        = session()->get('order_id');
        $order           = Order::where('id', $orderId)->where('status', 0)->firstOrFail();

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'order'));
    }

    public function depositInsert(Request $request)
    {

        $request->validate([
            'method_code' => 'required',
            'currency'    => 'required',
        ]);

        $orderId = session()->get('order_id');
        $order    = Order::where('id', $orderId)->where('status', 0)->firstOrFail();
        $user     = auth()->user();
        $gate     = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();

        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $order->total || $gate->max_amount < $order->total) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge    = $gate->fixed_charge + ($order->total * $gate->percent_charge / 100);
        $payable   = $order->total + $charge;
        $final_amo = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->user_id         = $user->id;
        $data->order_id        = $orderId;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $order->total;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amo       = $final_amo;
        $data->btc_amo         = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->try             = 0;
        $data->status          = 0;
        $data->save();
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }

        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function depositConfirm()
    {
        $track   = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', 0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return redirect()->route('user.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new     = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);

        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }

        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }

    public static function userDataUpdate($trx)
    {
        $general = GeneralSetting::first();
        $data    = Deposit::where('trx', $trx)->first();
        $order   = Order::where('id', $data->order_id)->where('status', 0)->first();
        $user    = User::find($data->user_id);
        if ($data->status == 0) {

            $data->status = 1;
            $data->save();

            $order->payment_status = 1;
            $order->status = 2;
            $order->save();

            Cart::where('user_id', $user->id)->delete();

            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = $user->id;
            $adminNotification->title     = 'Order successfully done via' . $data->gatewayCurrency()->name;
            $adminNotification->click_url = urlPath('admin.orders.detail', $order->id);
            $adminNotification->save();

            notify($user, 'ORDER_COMPLETE', [
                'trx'             => $order->deposit->trx,
                'method_name'     => 'Order successfully done via ' . $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount'   => showAmount($data->final_amo),
                'user_name'       => $user->username,
                'currency'        => $general->cur_text,
                'amount'          => showAmount($order->subtotal),
                'discount'        => showAmount($order->discount),
                'shipping_charge' => showAmount($order->shipping_charge),
                'final_amount'    => showAmount($order->total),
                'order_no'        => $order->order_no,
                'charge'          => showAmount($data->charge),
                'rate'            => showAmount($data->rate),
            ]);
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }

        if ($data->method_code > 999) {

            $pageTitle = 'Payment Confirm';
            $method    = $data->gatewayCurrency();
            $gateway   = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }

        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {

        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        $order = Order::where('id', $data->order_id)->where('status', 0)->first();

        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor   = new FormProcessor();
        $validationRule  = $formProcessor->valueValidation($formData);

        $request->validate($validationRule);

        $userData        = $formProcessor->processFormData($request, $formData);
        $data->detail    = $userData;
        $data->status    = 2; // pending
        $data->save();

        $order->payment_status = 1;
        $order->status   = 2;
        $order->save();

        $user = auth()->user();

        Cart::where('user_id', $user->id)->delete();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'Order successfully done via' . $data->gatewayCurrency()->name;
        $adminNotification->click_url = urlPath('admin.orders.detail', $order->id);
        $adminNotification->save();

        $general = GeneralSetting::first();

        notify($user, 'ORDER_COMPLETE_MANUAL', [
            'trx'             => $order->deposit->trx,
            'method_name'     => 'Order successfully done via ' . $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amo),
            'user_name'       => $user->username,
            'currency'        => $general->cur_text,
            'amount'          => showAmount($order->subtotal),
            'discount'        => showAmount($order->discount),
            'shipping_charge' => showAmount($order->shipping_charge),
            'final_amount'    => showAmount($order->total),
            'order_no'        => $order->order_no,
            'charge'          => showAmount($data->charge),
            'rate'            => showAmount($data->rate),
        ]);


        $notify[] = ['success', 'Your payment request has been processed.'];
        return redirect()->route('user.order.history')->withNotify($notify);
    }
}

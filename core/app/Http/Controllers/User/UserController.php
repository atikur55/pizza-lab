<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Deposit;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle            = 'Dashboard';
        $user                 = auth()->user();
        $orders               = Order::where('user_id', $user->id)->where('payment_status', '!=', 0)->latest()->with('deposit')->take(5)->get();
        $order['total']       = Order::where('user_id', $user->id)->count();
        $order['pending']     = Order::pending()->where('user_id', $user->id)->count();
        $order['processing']  = Order::processing()->where('user_id', $user->id)->count();
        $order['delivered']   = Order::delivered()->where('user_id', $user->id)->count();
        $order['cancelled']   = Order::cancelled()->where('user_id', $user->id)->count();

        $order['payments']    = Deposit::where('user_id', auth()->id())->where('status', 1)->count();
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'orders', 'order'));
    }

    public function payments(Request $request)
    {
        $pageTitle = 'Payment History';
        $payments = Deposit::where('user_id', auth()->id())->where('status', 1);

        if ($request->search) {
            $payments = $payments->where('trx', $request->search);
        }

        $payments = $payments->orderBy('id', 'desc')->with('order')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.payments', compact('pageTitle', 'payments'));
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = GeneralSetting::first();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }


    public function orderHistory()
    {
        $pageTitle    = 'My Orders';
        $orders       = Order::where('user_id', auth()->id())->where('payment_status', '!=', 0)->latest()->with('deposit')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.order.history', compact('pageTitle', 'orders'));
    }

    public function orderDetail($id)
    {
        $pageTitle    = 'Order Detail';
        $emptyMessage = 'No product found';
        $order        = Order::where('id', $id)->where('user_id', auth()->id())->with(['orderDetail.pizza', 'coupon', 'deposit.gateway', 'user'])->firstOrFail();
        return view($this->activeTemplate . 'user.order.detail', compact('pageTitle', 'order'));
    }
}

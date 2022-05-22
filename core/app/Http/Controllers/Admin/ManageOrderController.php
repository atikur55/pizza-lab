<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ManageOrderController extends Controller
{
    protected $pageTitle;

    public function index()
    {
        $this->pageTitle = 'All Orders';
        return $this->filterOrders();
    }

    public function pending()
    {
        $this->pageTitle = 'Pending Orders';
        return $this->filterOrders('pending');
    }

    public function processing()
    {
        $this->pageTitle = 'Processing Orders';
        return $this->filterOrders('processing');
    }

    public function delivered()
    {
        $this->pageTitle = 'Delivered Orders';
        return $this->filterOrders('delivered');
    }

    public function cancelled()
    {
        $this->pageTitle = 'Cancelled Orders';
        return $this->filterOrders('cancelled');
    }

    protected function filterOrders($scope = null)
    {
        $orders = Order::query();
        if ($scope) {
            $orders = $orders->$scope();
        }
        $request = request();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function ($q) use ($search) {
                $q->where('order_no', $search)->orWhereHas('user', function ($query) use ($search) {
                    $query->where('username', $search);
                });
            });
        }

        $orders = $orders->where('payment_status', '!=', 0)->whereHas('deposit', function ($query) {
            $query->where('status', '!=', 2);
        })->with('user', 'deposit')->latest()->paginate(getPaginate());

        $pageTitle = $this->pageTitle;

        return view('admin.order.index', compact('pageTitle', 'orders'));
    }

    public function userOrders(Request $request, $id)
    {

        $user      = User::findOrFail($id);
        $pageTitle = 'Order Logs of' . ' ' . $user->username;
        $orders    = Order::where('user_id', $user->id);

        if ($request->search) {
            $orders->where('order_no', $request->search);
        }

        $orders = $orders->with('user', 'deposit')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'orders'));
    }

    public function orderDetail($id)
    {
        $pageTitle = 'Order Detail';
        $order     = Order::where('id', $id)->with(['orderDetail.pizza', 'coupon', 'deposit', 'user'])->firstOrFail();
        return view('admin.order.detail', compact('pageTitle', 'order'));
    }

    public function orderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer',
        ]);

        $order = Order::where('id', $id)->with('user', 'deposit')->firstOrFail();
        $order->status = $request->status;
        $order->save();

        if ($request->status == 2) {
            $template = 'ORDER_PROCESSING';
        } elseif ($request->status == 3) {
            $template = 'ORDER_DELIVERED';
        } else {
            $template = 'ORDER_CANCELLED';
        }

        if ($order->payment_status == 2 && $request->status == 3) {
            $deposit         = $order->deposit;
            $deposit->status = 1;
            $deposit->save();
        }

        $user    = $order->user;
        $general = GeneralSetting::first();

        notify($user, $template, [
            'user_name'   => $user->username,
            'order_no'    => $order->order_no,
            'total'       => showAmount($order->total),
            'currency'    => $general->cur_text,
        ]);

        $notify[] = ['success', 'Order status changed successfully.'];
        return back()->withNotify($notify);
    }

    public function invoice($id)
    {
        $pageTitle = 'Print Invoice';
        $order     = Order::where('id', $id)->with(['orderDetail.pizza', 'coupon', 'deposit', 'user'])->firstOrFail();
        return view('admin.order.invoice', compact('order', 'pageTitle'));
    }
}

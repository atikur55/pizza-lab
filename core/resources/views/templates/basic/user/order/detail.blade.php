@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row g-3 fs--14px mb-5">
        <h6>@lang('Order Details')</h6>
        <div class="col-md-6">
            <div class="preview-details mt-3">
                <ul class="list-group text-center">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Order No')</span>
                        <span>{{ __($order->order_no) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Total Price')</span>
                        <span>{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }} {{ $general->cur_text }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Payment Type')</span>
                        @if ($order->payment_status == 1)
                            <span>{{ __(@$order->deposit->gateway->name) }} @lang('payment gateway')</span>
                        @else
                            <span>@lang('Cash on delivery')</span>
                        @endif
                    </li>
                    @if (@$order->deposit->trx)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@lang('Payment Trx')</span>
                            <span>{{ @$order->deposit->trx }}</span>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="preview-details mt-3">
                <ul class="list-group text-center">

                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Delivery Address')</span>
                        <span>{{ $order->address }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Order Date')</span>
                        <span>{{ showDateTime($order->created_at) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Order Status')</span>
                        @php
                            echo $order->statusBadge;
                        @endphp
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="table-responsive--sm">
        <table class="custom--table table">
            <thead>
                <tr>
                    <th>@lang('Name')</th>
                    <th>@lang('Size')</th>
                    <th>@lang('Quantity')</th>
                    <th>@lang('Price')</th>
                    <th>@lang('Total Price')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderDetail as $detail)
                    <tr>
                        <td data-label="@lang('Order No')">
                            <h6 class="fs--16px">
                                <a href="">{{ @$detail->pizza->name }}</a>
                            </h6>
                        </td>
                        <td data-label="@lang('Size')">
                            <strong>{{ $detail->size }}"</strong>
                        </td>
                        <td data-label="@lang('Quantity')">
                            <strong>{{ $detail->quantity }}</strong>
                        </td>
                        <td data-label="@lang('Price')">
                            <strong>{{ $general->cur_sym }}{{ showAmount($detail->price) }}</strong>
                        </td>
                        <td data-label="@lang('Subtotal')">
                            <strong>{{ $general->cur_sym }}{{ showAmount($detail->price * $detail->quantity) }}</strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text--danger justify-content-center text-center">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="total-wrapper">
        <div class="d-flex justify-content-between flex-wrap">
            <strong>@lang('Subtotal :')</strong><strong> {{ $general->cur_sym }}{{ showAmount($order->subtotal) }}</strong></strong>
        </div>
        <div class="d-flex justify-content-between flex-wrap">
            <strong>@lang('Shipping Charge :')</strong><strong> {{ $general->cur_sym }}{{ showAmount($order->shipping_charge) }}</strong>
        </div>
        @if ($order->payment_status == 1)
            <div class="d-flex justify-content-between flex-wrap">
                <strong>@lang('Payment Charge :')</strong><strong> {{ $general->cur_sym }}{{ showAmount($order->deposit->charge) }}</strong>
            </div>
        @endif
        @if ($order->coupon_id)
            <div class="d-flex justify-content-between flex-wrap">
                <strong>@lang('Coupon Code :')</strong><strong> {{ $order->coupon_code }}</strong>
            </div>

            <div class="d-flex justify-content-between flex-wrap">
                <strong>@lang('Discount :')</strong><strong> {{ $general->cur_sym }}{{ showAmount($order->discount) }}</strong>
            </div>
        @endif
        <div class="d-flex justify-content-between flex-wrap border-0">
            <strong>@lang('Grand Total :')</strong>
            @if ($order->payment_type == 2)
                <strong>{{ $general->cur_sym }}{{ showAmount(@$order->total) }}</strong>
            @else
                <strong>{{ $general->cur_sym }}{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }}</strong>
            @endif
        </div>
    </div>
@endsection
@push('style')
    <style>
        .total-wrapper {
            max-width: 300px;
            margin-left: auto;
            background: #fff;
            font-size: 14px;
            padding: 15px;
            border-radius: 5px;
        }

        @media (max-width:575px) {
            .total-wrapper {
                margin-right: 0;
            }
        }

        .total-wrapper>div {
            padding: 6px 0;
            border-bottom: 1px solid #f2f2f2;
        }

    </style>
@endpush

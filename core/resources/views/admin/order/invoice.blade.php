@php
$contact = getContent('contact_us.content', true);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('Invoice')</title>
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <style>
        .border-0 th,
        .border-0 td {
            border: 0
        }

    </style>
</head>

<body onload="window.print()">
    <div class="invoice mt-5">
        <div class="row align-items-center mt-3">
            <div class="col-6">
                <h4>{{ __($general->site_name) }}</h4>
            </div>
            <div class="col-6">
                <h5 class="text-end">@lang('Date:') {{ now()->format('d/m/Y') }}</h5>
            </div>
        </div>
        <hr>
        <div class="row invoice-info">
            <div class="col-4">
                @lang('From')
                <address class="fw-light">
                    <strong>{{ __($general->site_name) }}</strong><br>
                    <strong>{{ __(@$contact->data_values->contact_address) }}</strong><br>
                    <strong>@lang('Phone:') {{ __(@$contact->data_values->contact_number) }}</strong><br>
                    <strong>@lang('Email:') {{ __(@$contact->data_values->email_address) }}</strong>
                </address>
            </div>
            <div class="col-4">
                @php
                    $address = json_decode($order->address);
                @endphp
                @lang('To')
                <address class="fw-light">
                    <strong>{{ __($order->user->fullname) }}</strong><br>
                    <strong>{{ $order->address }}</strong><br>
                    <strong>@lang('Phone:') {{ __($order->user->mobile) }}</strong><br>
                    <strong>@lang('Email:') {{ __($order->user->email) }}</strong>
                </address>
            </div>
            <div class="col-4 fw-light">
                <strong>@lang('Order No'):</strong> <strong>{{ __($order->order_no) }}</strong><br>
                <strong>@lang('Order Date'):</strong><strong> {{ showDateTime($order->created_at) }}</strong><br>
                <strong>@lang('Total Amount'):</strong><strong>{{ $general->cur_sym }}{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }}</strong>
            </div>
        </div>

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive--md">
                <table class="table-bordered table">
                    <tbody>
                        <tr>
                            <th>@lang('Pizza Name')</th>
                            <th>@lang('Size')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Total Price')</th>
                        </tr>
                        @forelse($order->orderDetail as $detail)
                            <tr>
                                <td data-label="@lang('Pizza Name')">
                                    <span>{{ __(@$detail->pizza->name) }}</span>
                                </td>
                                <td data-label="@lang('Size')">
                                    <span>{{ __($detail->size) }}"</span>
                                </td>
                                <td data-label="@lang('Quantity')">
                                    <span>{{ $detail->quantity }}</span>
                                </td>

                                <td data-label="@lang('Price')">
                                    <span>{{ showAmount($detail->price) }} {{ $general->cur_text }}</span>
                                </td>

                                <td data-label="@lang('Total Price')">
                                    <span>{{ showAmount($detail->price * $detail->quantity) }} {{ $general->cur_text }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row mt-30 mb-none-30 justify-content-end">
            <div class="col-lg-6 mb-30">
                <div class="table-responsive">
                    <table class="text-end table border-0">
                        <tbody>
                            <tr>
                                <th style="width:80%">@lang('Subtotal'):</th>
                                <td>{{ $general->cur_sym }}{{ showAmount($order->subtotal) }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Shipping Charge'):</th>
                                <td>{{ $general->cur_sym }}{{ showAmount($order->shipping_charge) }} </td>
                            </tr>
                            @if ($order->payment_type == 1)
                                <tr>
                                    <th>@lang('Payment Charge :')</th>
                                    <td>{{ $general->cur_sym }}{{ showAmount($order->deposit->charge) }}</td>
                                </tr>
                            @endif

                            @if ($order->coupon_id)
                                <tr>
                                    <th>@lang('Coupon Code :')</th>
                                    <td>{{ $order->coupon_code }}</td>
                                </tr>

                                <tr>
                                    <th>@lang('Discount :')</th>
                                    <td>{{ $general->cur_sym }}{{ showAmount($order->discount) }}</td>
                                </tr>
                            @endif

                            @if ($order->payment_status == 1)
                                <th>@lang('Payment Charge :')</th>
                                <td>{{ $general->cur_sym }}{{ showAmount($order->deposit->charge) }}</td>
                            @endif

                            <tr>
                                <th>@lang('Grand Total :')</th>
                                <td>
                                    {{ $general->cur_sym }}{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

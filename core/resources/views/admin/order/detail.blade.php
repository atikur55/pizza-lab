@php
$contact = getContent('contact_us.content', true);
@endphp
@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title d-inline-block mb-0">@lang('Information of') {{ $order->order_no }}</h5>
                    <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn--primary float-end" target="_blank">
                        <i class="las la-print"></i> @lang('Print Invoice')
                    </a>
                </div>
                <div class="card-body">
                    <div class="invoice">
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <h4><i class="fa fa-globe"></i> {{ __($general->site_name) }}</h4>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="text-end">@lang('Date:') {{ now()->format('d/m/Y') }}</h5>
                            </div>
                        </div>

                        <hr>

                        <div class="row invoice-info">
                            <div class="col-md-4">
                                @lang('From')
                                <address class="font-weight-light">
                                    <strong>{{ __($general->site_name) }}</strong><br>
                                    {{ __(@$contact->data_values->contact_address) }}<br>
                                    @lang('Phone:') {{ __(@$contact->data_values->contact_number) }}<br>
                                    @lang('Email:') {{ __(@$contact->data_values->email_address) }}
                                </address>
                            </div>

                            <div class="col-md-4">
                                @lang('To')
                                <address class="font-weight-light">
                                    <strong>{{ __($order->user->fullname) }}</strong><br>
                                    {{ $order->address }}<br>
                                    @lang('Phone:') {{ __($order->user->mobile) }}<br>
                                    @lang('Email:') {{ __($order->user->email) }}
                                </address>
                            </div>
                            <div class="col-md-4 font-weight-light">
                                <b>@lang('Order No'):</b> {{ __($order->order_no) }}<br>
                                <b>@lang('Order Date'):</b> {{ showDateTime($order->created_at) }}<br>
                                <b>@lang('Total Amount'):</b>
                                {{ $general->cur_sym }}{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }}
                            </div>
                        </div>

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive--md">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>@lang('Pizza Name')</th>
                                            <th>@lang('Size')</th>
                                            <th>@lang('Quantity')</th>
                                            <th>@lang('Price')</th>
                                            <th>@lang('Total Price')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->orderDetail as $detail)
                                            <tr>
                                                <td data-label="@lang('Pizza Name')">
                                                    <a href="{{ route('admin.orders.detail', $order->id) }}" class="text--dark">
                                                        {{ __(@$detail->pizza->name) }}
                                                    </a>
                                                </td>
                                                <td data-label="@lang('Size')">
                                                    <strong>{{ __($detail->size) }}"</strong>
                                                </td>
                                                <td data-label="@lang('Quantity')">
                                                    <strong>{{ $detail->quantity }}</strong>
                                                </td>

                                                <td data-label="@lang('Price')">
                                                    <strong>{{ showAmount($detail->price) }} {{ $general->cur_text }}</strong>
                                                </td>

                                                <td data-label="@lang('Subtotal')">
                                                    <strong>{{ showAmount($detail->price * $detail->quantity) }} {{ $general->cur_text }}</strong>
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
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">@lang('Subtotal'):</th>
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
                                                    @if ($order->payment_type == 2)
                                                        {{ $general->cur_sym }}{{ showAmount(@$order->total) }}
                                                    @else
                                                        {{ $general->cur_sym }}{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.orders.all') }}" class="btn btn-sm btn-outline--primary"><i class="la la-undo"></i>@lang('Back')</a>
@endpush

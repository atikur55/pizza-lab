@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-md-4 col-sm-6 col-lg-6 col-xl-4">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between">
                    <div class="dashboard-card__icon text-dark">
                        <i class="las la-list-ul"></i>
                    </div>
                    <h3 class="dashboard-card__amount">{{ $order['total'] }}</h3>
                </div>
                <div class="dashboard-card__content">
                    <p class="caption text-white">@lang('All Orders')</p>
                </div>
            </div><!-- dashboard-card end -->
        </div>
        <div class="col-md-4 col-sm-6 col-lg-6 col-xl-4">
            <div class="dashboard-card bg--warning">
                <div class="d-flex justify-content-between">
                    <div class="dashboard-card__icon text--warning">
                        <i class="las la-spinner"></i>
                    </div>
                    <h3 class="dashboard-card__amount">{{ $order['pending'] }}</h3>
                </div>
                <div class="dashboard-card__content">
                    <p class="caption text-white">@lang('Pending Orders')</p>
                </div>
            </div><!-- dashboard-card end -->
        </div>

        <div class="col-md-4 col-sm-6 col-lg-6 col-xl-4">
            <div class="dashboard-card bg--success">
                <div class="d-flex justify-content-between">
                    <div class="dashboard-card__icon text--success">
                        <i class="lar la-check-circle"></i>
                    </div>
                    <h3 class="dashboard-card__amount">{{ $order['processing'] }}</h3>
                </div>

                <div class="dashboard-card__content">
                    <p class="caption text-white">@lang('Processing Orders')</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-lg-6 col-xl-4">
            <div class="dashboard-card bg--primary">
                <div class="d-flex justify-content-between">
                    <div class="dashboard-card__icon text--primary">
                        <i class="las la-list-alt"></i>
                    </div>
                    <h3 class="dashboard-card__amount">{{ $order['delivered'] }}</h3>
                </div>
                <div class="dashboard-card__content">
                    <p class="caption text-white">@lang('Delivered Orders')</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-lg-6 col-xl-4">
            <div class="dashboard-card bg--danger">
                <div class="d-flex justify-content-between">
                    <div class="dashboard-card__icon text--danger">
                        <i class="las la-times-circle"></i>
                    </div>
                    <h3 class="dashboard-card__amount">{{ $order['cancelled'] }}</h3>
                </div>
                <div class="dashboard-card__content">
                    <p class="caption text-white">@lang('Cancelled Orders')</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-lg-6 col-xl-4">
            <div class="dashboard-card bg--info">
                <div class="d-flex justify-content-between">
                    <div class="dashboard-card__icon text--info">
                        <i class="las la-money-bill-wave"></i>
                    </div>
                    <h3 class="dashboard-card__amount">{{ $order['payments'] }}</h3>
                </div>
                <div class="dashboard-card__content">
                    <p class="caption text-white">@lang('Payments')</p>
                </div>
            </div>
        </div>

    </div><!-- row end -->
    <h6 class="mt-5 mb-2">@lang('Latest Orders')</h6>
    <div class="table-responsive table-responsive--md">
        <table class="custom--table table">
            <thead>
                <tr>
                    <th>@lang('Order No')</th>
                    <th>@lang('Payment Type')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td data-label="@lang('Order No')">{{ $order->order_no }}</td>
                        <td data-label="@lang('Payment Type')">
                            @if ($order->payment_status == 1)
                                @lang('Online Payment')
                            @else
                                @lang('Cash On Delivery')
                            @endif
                        </td>
                        <td data-label="@lang('Amount')">
                            <strong>{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }} {{ $general->cur_text }}</strong>
                        </td>
                        <td data-label="@lang('Status')">
                            @php
                                echo $order->statusBadge;
                            @endphp

                            @if (@$order->deposit->admin_feedback != null)
                                <span class="badge badge--danger detailBtn" data-admin_feedback="{{ __(@$order->deposit->admin_feedback) }}"><i class="fa fa-info"></i></span>
                            @endif
                        </td>
                        <td data-label="@lang('Action')">
                            <div>
                                <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn--base" data-bs-toggle="tooltip" data-bs-position="top" title="@lang('Detail')">
                                    <i class="las la-desktop"></i>
                                </a>
                            </div>
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
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--base">
                    <h5 class="modal-title text-white">@lang('Details')</h5>
                </div>
                <div class="modal-body">
                    <div class="payment-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn-sm w-100" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .detailBtn {
            cursor: pointer;
        }

    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.payment-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

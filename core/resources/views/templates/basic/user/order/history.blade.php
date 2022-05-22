@extends($activeTemplate.'layouts.master')
@section('content')
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
    {{ $orders->links() }}

    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--base">
                    <h5 class="modal-title text-white">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
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

@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Order No.')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Payment Type')</th>
                                    @if (request()->routeIs('admin.orders.all'))
                                        <th>@lang('Order Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td data-label="@lang('Order No.')">
                                            <span class="fw-bold">{{ __($order->order_no) }}</span>
                                        </td>

                                        <td data-label="@lang('User')">
                                            <a href="{{ route('admin.users.detail', @$order->user->id) }}">{{ @$order->user->username }}</a><br>{{ @$order->user->email }}
                                        </td>

                                        <td data-label="@lang('Price')">
                                            <strong>{{ showAmount(@$order->deposit->amount + @$order->deposit->charge) }} {{ $general->cur_text }}</strong>
                                        </td>

                                        <td data-label="@lang('Created At')">
                                            {{ showDateTime($order->created_at) }} <br>
                                            {{ diffForHumans($order->created_at) }}
                                        </td>

                                        <td data-label="@lang('Payment Type')">
                                            @if ($order->payment_status == 1)
                                                <strong>@lang('Online Payment')</strong>
                                            @else
                                                <strong>@lang('Cash On Delivery')</strong>
                                            @endif
                                        </td>

                                        @if (request()->routeIs('admin.orders.all'))
                                            <td data-label="@lang('Order Status')">
                                                @php
                                                    echo $order->statusBadge;
                                                @endphp
                                            </td>
                                        @endif

                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-sm btn-outline--info ml-1">
                                                <i class="las la-desktop  "></i> @lang('Details')
                                            </a>

                                            @if ($order->status == 2)
                                                <button type="button" class="btn btn-sm btn-outline--primary ms-1 orderStatusModal" data-url="{{ route('admin.orders.status', $order->id) }}" data-status="{{ $order->status }}">
                                                    <i class="la la-spinner"></i> @lang('Make as Processing')
                                                </button>
                                            @elseif($order->status == 3)
                                                <button type="button" class="btn btn-sm btn-outline--success ms-1 orderStatusModal"  data-url="{{ route('admin.orders.status', $order->id) }}" data-status="{{ $order->status }}">
                                                    <i class="lar la-check-circle"></i> @lang('Mark as Delivered')
                                                </button>
                                            @endif


                                            @if (request()->routeIs('admin.orders.all') || request()->routeIs('admin.orders.pending') || request()->routeIs('admin.orders.processing'))
                                                @if ($order->status == 2)
                                                    <button type="button" class="btn btn-sm btn-outline--dark ms-1 cancelOrderModal" data-url="{{ route('admin.orders.status', $order->id) }}">
                                                        <i class="la la-times-circle"></i> @lang('Cancel')
                                                    </button>
                                                @elseif($order->status == 3)
                                                    <button type="button" class="btn btn-sm btn-outline--dark ms-1 cancelOrderModal" data-url="{{ route('admin.orders.status', $order->id) }}">
                                                        <i class="la la-times-circle"></i> @lang('Cancel')
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline--dark ms-1 disabled">
                                                        <i class="la la-times-circle"></i> @lang('Cancel')
                                                    </button>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($orders) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="orderStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="modal-detail"></p>
                        <input type="hidden" name="status">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .disabled-order {
            background-color: #4634ff4d;
            cursor: no-drop;
        }

        .disabled-order:hover {
            background-color: #4634ff4d;
        }

        .disabled-cancel-order {
            background-color: #ea545575;
            cursor: no-drop;
        }

        .disabled-cancel-order:hover {
            background-color: #ea545575;
        }

    </style>
@endpush


@push('breadcrumb-plugins')
    <form action="" method="GET" class="form-inline float-sm-end">
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Order NO')" value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"
            $('.orderStatusModal').on('click', function() {
                var modal = $('#orderStatusModal');
                var url = $(this).data('url');
                var orderStatus = $(this).data('status');
                if (orderStatus == 2) {
                    status = 3;
                } else if (orderStatus == 3) {
                    status = 1;
                }
                modal.find('form').attr('action', url);
                modal.find('[name=status]').val(status);
                modal.find('.modal-detail').text(`@lang('Are you sure to change the order status?')`);
                modal.modal('show');
            });
            $('.cancelOrderModal').on('click', function() {
                var modal = $('#orderStatusModal');
                var url = $(this).data('url');
                var orderStatus = 4;
                modal.find('form').attr('action', url);
                modal.find('[name=status]').val(orderStatus);
                modal.find('.modal-detail').text(`@lang('Are you sure to cancel this order?')`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

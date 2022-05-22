@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Code')</th>
                                <th>@lang('Minimum Order Amount')</th>
                                <th>@lang('Discount')</th>
                                <th>@lang('Start Date')</th>
                                <th>@lang('Validity')</th>
                                <th>@lang('Status')</th>
                                <th> @lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td data-label="@lang('S.N.')">{{ $coupons->firstItem() + $loop->index }}</td>
                                    <td data-label="@lang('Code')">
                                        <span>{{ __($coupon->code) }}</span>
                                    </td>
                                    <td data-label="@lang('Minimum Order Amount')">
                                        <span class="name">{{ $general->cur_sym }}{{ showAmount($coupon->min_order)}}</span>
                                    </td>
                                    <td data-label="@lang('Discount')">
                                        <span class="name">{{ showAmount($coupon->amount) }}</span>
                                        <span>@if ($coupon->discount_type == 1) {{ $general->cur_text }} @else @lang('%') @endif</span>
                                    </td>

                                    <td data-label="@lang('Start Date')">
                                        <span>{{ $coupon->start_date }}</span>
                                    </td>

                                    <td data-label="@lang('Validity')">
                                        @if ($coupon->end_date >= now()->format('Y-m-d'))
                                            {{\Carbon\Carbon::parse($coupon->end_date)->diffInDays(\Carbon\Carbon::now()->format('Y-m-d'))}}
                                            @lang('Days Left')
                                        @else
                                            @lang('Expired')
                                            {{\Carbon\Carbon::parse($coupon->end_date)->diffInDays(\Carbon\Carbon::now()->format('Y-m-d'))}}
                                            @lang('Days ago')
                                        @endif
                                    </td>

                                    <td data-label="@lang('Status')">
                                        @if ($coupon->status == 1)
                                        <span class="text--small badge font-weight-normal badge--success">
                                            @lang('Enabled')</span>
                                        @else
                                        <span class="text--small badge font-weight-normal badge--danger">
                                            @lang('Disabled')</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                        <button class="btn btn-sm btn-outline--primary editButton"
                                            data-id="{{ $coupon->id }}"
                                            data-code="{{ $coupon->code }}"
                                            data-status="{{ $coupon->status }}"
                                            data-end_date="{{ $coupon->end_date }}"
                                            data-start_date="{{ $coupon->start_date }}"
                                            data-amount="{{ $coupon->amount }}"
                                            data-discount_type="{{ $coupon->discount_type }}"
                                            data-min_order="{{ $coupon->min_order }}">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </button>
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
            @if ($coupons->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($coupons) }}
            </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="createCoupon" tabindex="-1" role="dialog" aria-labelledby="createCouponLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createCouponLabel"></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="">
                @csrf
                <div class="modal-body">
                    <div class="row form-group">
                        <label>@lang('Code')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{ old('code') }}" name="code" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label>@lang('Amount')</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" required value="{{ old('amount') }}">
                                <select name="discount_type" class="input-group-text">
                                    <option value="1">{{ __($general->cur_text) }}</option>
                                    <option value="2">@lang('%')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label>@lang('Minimum Order')</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" step="any" name="min_order" class="form-control" required value="{{ old('min_order') }}">
                                <div class="input-group-text">{{ $general->cur_text }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label>@lang('Start Date')<span class="text--danger">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="datepicker-here form-control" data-language='en'
                                data-date-format="yyyy-mm-dd" data-position='bottom left'
                                placeholder="@lang('Select date')" name="start_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label>@lang('End Date')<span class="text--danger">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="datepicker-here form-control" data-language='en'
                                data-date-format="yyyy-mm-dd" data-position='bottom left'
                                placeholder="@lang('End date')" name="end_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="row form-group status">
                        <label>@lang('Status')</label>
                        <div class="col-sm-12">
                            <input type="checkbox" id="status" data-width="100%" data-onstyle="-success"
                            data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                            data-off="@lang('Disabled')" name="status">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('breadcrumb-plugins')
<div class="d-flex flex-colum flex-wrap gap-2 justify-content-end align-items-center">
    <a class="btn btn-lg btn-outline--primary me-2 createButton"><i class="las la-plus"></i>@lang('Add New')</a>
    <form action="" method="GET" class="form-inline float-sm-end">
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Code')" value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
@endpush
@push('script-lib')
<script src="{{asset('assets/admin/js/vendor/datepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/vendor/datepicker.en.js')}}"></script>
@endpush
@push('script')
<script>
        $('.datepicker-here').datepicker();

        (function($) {
            "use strict";
            $('.createButton').on('click', function(e) {
                e.preventDefault();
                var modal = $('#createCoupon');
                modal.find('.modal-title').text(`@lang('Add New Coupon')`);
                modal.find('.status').addClass('d-none');
                modal.find('form').attr('action', `{{ route('admin.coupon.store','') }}`);
                modal.modal('show');
            });
            $('.editButton').on('click', function() {
                var modal = $('#createCoupon');
                modal.find('form').attr('action', `{{ route('admin.coupon.store','') }}/${$(this).data('id')}`);
                var name = $(this).data('code');
                var status = $(this).data('status');
                var end_date = $(this).data('end_date');
                var start_date = $(this).data('start_date');
                var discount = $(this).data('discount');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=code]').val($(this).data('code'));
                modal.find('input[name=amount]').val(parseFloat($(this).data('amount')).toFixed(2));
                modal.find('input[name=end_date]').val($(this).data('end_date'));
                modal.find('input[name=min_order]').val(parseFloat($(this).data('min_order')).toFixed(2));
                modal.find('input[name=end_date]').val($(this).data('end_date'));
                modal.find('input[name=start_date]').val($(this).data('start_date'));
                modal.find('select[name=discount_type]').val($(this).data('discount_type'));
                modal.find('.modal-title').text(`@lang('Update Coupon')`);
                modal.find('.status').removeClass('d-none');

                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }
                modal.modal('show')
            });
            $('#createCoupon').on('hidden.bs.modal', function () {
                $('#createCoupon form')[0].reset();
            });
        })(jQuery);
</script>
@endpush

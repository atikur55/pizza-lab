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
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Shipping Charge')</th>
                                    <th>@lang('Status')</th>
                                    <th> @lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shippings as $shipping)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Name')"><span class="name">{{ __($shipping->name) }}</span></td>
                                        <td data-label="@lang('Shipping Charge')">
                                            <span class="name">{{ __($general->cur_sym) }}{{ showAmount($shipping->price) }}</span>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($shipping->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Enabled')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--danger">@lang('Disabled')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="btn btn-sm btn-outline--primary editButton" data-id="{{ $shipping->id }}" data-name="{{ __($shipping->name) }}" data-status="{{ __($shipping->status) }}" data-price="{{ __($shipping->price) }}">
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

            </div>
        </div>
    </div>
    <div class="modal fade" id="createShipping" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"></h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Amount')</label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input type="number" step="any" name="price" class="form-control" required value="{{ old('price') }}">
                                    <div class="input-group-text">{{ $general->cur_text }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group status">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45" id="btn-save" value="add">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-colum justify-content-end align-items-center flex-wrap gap-2">
        <a class="btn btn-lg btn-outline--primary me-2 createButton"><i class="las la-plus"></i>@lang('Add New')</a>

        <form action="" method="GET" class="form-inline float-sm-end">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Shipping Method')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.createButton').on('click', function(e) {
                e.preventDefault();
                var modal = $('#createShipping');
                modal.find('.modal-title').text(`@lang('Add New Shipping Method')`);
                modal.find('form').attr('action', `{{ route('admin.shipping.store', '') }}`);
                modal.find('.status').addClass('d-none');
                modal.modal('show');
            });

            $('.editButton').on('click', function(e) {
                e.preventDefault();
                var modal = $('#createShipping');
                var name = $(this).data('name');
                var status = $(this).data('status');
                var price = $(this).data('price');
                modal.find('.modal-title').text(`@lang('Update Shipping Method')`);
                modal.find('form').attr('action', `{{ route('admin.shipping.store', '') }}/${$(this).data('id')}`);
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=price]').val($(this).data('price'));
                modal.find('.status').removeClass('d-none');
                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }
                modal.modal('show');
            });

            $('.deleteButton').on('click', function() {
                var modal = $('#deleteModal');
                var action = $(this).data('action');
                modal.find('form').attr('action', `${action}`);
                modal.modal('show');
            });
            $('#createShipping').on('hidden.bs.modal', function() {
                $('#createShipping form')[0].reset();
            });
        })(jQuery);
    </script>
@endpush

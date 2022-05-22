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
                                    <th>@lang('Category')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Size & Price')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pizzas as $pizza)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $pizzas->firstItem() + $loop->index }}</td>

                                        <td data-label="@lang('Name')">
                                            <span class="fw-bold ms-2">{{ __($pizza->name) }}</span>
                                        </td>

                                        <td data-label="@lang('Category')">
                                            <span>{{ __(@$pizza->category->name) }}</span>
                                        </td>

                                        <td data-label="@lang('Status')">
                                            @if ($pizza->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success statusBtn" data-status="{{ $pizza->status }}" data-action="{{ route('admin.pizza.status', $pizza->id) }}">@lang('Available')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--danger statusBtn" data-status="{{ $pizza->status }}" data-action="{{ route('admin.pizza.status', $pizza->id) }}">@lang('Not Avaliable')</span>
                                            @endif
                                        </td>

                                        <td data-label="@lang('Size & Price')">
                                            <button class="btn btn-sm btn-outline--info viewDetailBtn" data-size="{{ $pizza->pizzaSize }}"><i class="las la-eye"></i> @lang('View')</button>
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.pizza.edit', $pizza->id) }}" class="btn btn-sm btn-outline--primary">
                                                <i class="la la-pencil"></i> @lang('Edit')
                                            </a>

                                            <a href="{{ route('admin.pizza.reviews', $pizza->id) }}" class="btn btn-sm btn-outline--warning">
                                                <i class="las la-star"></i> @lang('Reviews')
                                            </a>
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
                @if ($pizzas->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($pizzas) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"> @lang('Size Information')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table--light table">
                        <thead>
                            <tr>
                                <th>@lang('Size')</th>
                                <th>@lang('Price')</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel"> @lang('Confirmation Alert!')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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


@push('breadcrumb-plugins')
    <div class="d-flex flex-colum justify-content-end align-items-center flex-wrap gap-2">
        <a href="{{ route('admin.pizza.create') }}" class="btn btn-lg btn-outline--primary me-2"><i class="las la-plus"></i>@lang('Add New')</a>
        <form action="" method="GET" class="form-inline float-sm-end">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Pizza Name')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush


@push('style')
    <style>
        .badge {
            cursor: pointer;
        }

    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.viewDetailBtn').on('click', function(e) {
                e.preventDefault();
                var modal = $('#detailModal')
                var size = $(this).data('size');
                modal.find('tbody').html('');
                $.each(size, function(indexInArray, value) {
                    modal.find('tbody').append(`<tr>
                        <td>${value.size}"</td>
                        <td>${parseFloat(value.price).toFixed(2)} {{ $general->cur_text }}</td>
                    </tr>`);
                });
                modal.modal('show');
            });

            $('.statusBtn').on('click', function() {
                var modal = $('#statusModal')
                var status = $(this).data('status');
                var action = $(this).data('action');
                let text;
                if (status == 1) {
                    text = 'not available';
                } else {
                    text = 'available';
                }
                modal.find('form').attr('action', `${action}`);
                modal.find('[name=status]').val(status);
                modal.find('.modal-detail').text(`@lang('Are you sure to change this ${text}?')`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

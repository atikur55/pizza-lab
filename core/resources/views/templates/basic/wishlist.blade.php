@extends($activeTemplate.'layouts.'.$layout)
@section('content')
    @if ($layout == 'frontend')
        <section class="pt-80 pb-80">
    @endif
    <div class="@if ($layout == 'frontend') col-lg-8  m-auto @endif">
        <div class="table-responsive table-responsive--md">
            <table class="custom--table table">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Ratings')</th>
                        <th>@lang('More')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pizzas as $pizza)
                        <tr>
                            <td data-label="@lang('Name')">
                                <div class="user justify-content-end justify-content-lg-start">
                                    <div class="thumb">
                                        <img src="{{ getImage(getFilePath('pizza') . '/' . $pizza->image, getFileSize('pizza')) }}" alt="@lang('image')" class="plugin_bg">
                                    </div>
                                    <span class="fw-bold ms-2" class="pizzaName" data-pizza_id="{{ $pizza->id }}">{{ __($pizza->name) }}</span>
                                </div>
                            </td>

                            <td data-label="@lang('Price')">
                                <span class="price">{{ $general->cur_sym }}{{ showAmount(@$pizza->pizzaPrice->price) }}</span>
                            </td>

                            <td data-label="@lang('Rating')">
                                <div class="ratings">
                                    @php
                                        $star = showPizzaRatings($pizza->avg_rating);
                                        echo $star;
                                    @endphp
                                </div>
                            </td>

                            <td data-label="@lang('Remove')">
                                <a href="{{ route('pizza.detail', [$pizza->id, slug($pizza->name)]) }}" class="btn btn-sm btn--base me-2" data-bs-toggle="tooltip" data-bs-position="top" title="@lang('Detail')"><i class="las la-cart-plus"></i></a>

                                <button type="button" class="btn btn-sm btn--dark remove-wishlist" data-pizza_id="{{ $pizza->id }}" data-bs-toggle="tooltip" data-bs-position="top" title="@lang('Remove')"><i class="las la-times"></i></button>
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
    </div>
    @if ($layout == 'frontend')
        </section>
    @endif
    <div class="modal fade" id="removeWishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--base">
                    <strong class="modal-title text-white">@lang('Confirmation Alert!')</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this pizza?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn--base btn-sm remove-single-wishlist">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use script";
            getWishlistCount();

            function getWishlistCount() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get.wishlist.count') }}",
                    success: function(response) {
                        var total = Object.keys(response).length;
                        $.each(response, function(indexInArray, value) {
                            $(document).find(`[data-pizza_id='${value.pizza_id}']`).closest('.wishlist-btn').addClass('active');
                        });
                        $('.wishlist-count').text(total);
                    }
                });
            }

            let removeableWishlistItem = null;
            let modal = $('#removeWishlistModal');

            $('.remove-wishlist').on('click', function() {
                removeableWishlistItem = $(this).closest("tr");
                let modal = $('#removeWishlistModal');
                modal.modal('show');
            });

            $('.remove-single-wishlist').on('click', function() {
                let pizzaId = removeableWishlistItem.find('.remove-wishlist').data('pizza_id');

                $.ajax({
                    method: "GET",
                    url: "{{ route('remove.wishlist') }}",
                    data: {
                        pizzaId: pizzaId
                    },
                    success: function(response) {
                        if (response.success) {
                            removeableWishlistItem.remove();
                            getWishlistCount();
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
                modal.modal('hide');
            });
        })(jQuery);
    </script>
@endpush

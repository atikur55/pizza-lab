@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-80 pb-80">
        <div class="container">
            <div class="order-track-wrapper">
                <div class="search-area">
                    <div class="input-group">
                        <input type="text" class="form-control form--control" name="order_no" placeholder="@lang('Order number')" autocomplete="off">
                        <button type="submit" class="btn btn--base track-btn px-sm-3 px-2">@lang('Track Order')</button>
                    </div>
                </div>
                <div class="order-track d-flex justify-content-between show_order mt-5 flex-wrap">
                    <div class="track-item">
                        <div class="icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/pending.png') }}" alt="order">
                        </div>
                        <div class="content">
                            <h6 class="title">@lang('Pending')</h6>
                        </div>
                    </div>
                    <div class="track-item">
                        <div class="icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/confirmed.png') }}" alt="order">
                        </div>
                        <div class="content">
                            <h6 class="title">@lang('Processing')</h6>
                        </div>
                    </div>
                    <div class="track-item">
                        <div class="icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/delivered.png') }}" alt="order">
                        </div>
                        <div class="content">
                            <h6 class="title">@lang('Delivered')</h6>
                        </div>
                    </div>
                </div>
                <div class="emptyMessage d-none"></div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.track-btn').on('click', function(e) {
                e.preventDefault();
                $('.track-item').removeClass('active');
                $('.emptyMessage').addClass('d-none');
                var orderNumber = $('[name=order_no]').val();

                if (!orderNumber) {
                    notify('error', '@lang("Please enter the order number")');
                    return;
                }

                $.ajax({
                    url: `{{ route('get.track.order', '') }}/${orderNumber}`,
                    method: "GET",
                    success: function(response) {
                        if (response.error) {
                            notify('error', response.error);
                            return;
                        } else if (response.emptyMessage) {
                            $('.show_order').addClass('d-none');
                            $('.emptyMessage').removeClass('d-none');
                            $('.emptyMessage').html(`<h6 class="text--danger text-center mt-5">${response.emptyMessage}</h6>`)
                        } else {
                            $('.show_order').removeClass('d-none');
                            $('.show_order').addClass('opacity-100');
                            var trackItem = $(".track-item");
                            var status = response.order.status;
                            let orderStatus;

                            if (status == 1) {
                                orderStatus = 2;
                            } else if (status == 2) {
                                orderStatus = 0;
                            } else if (status == 3) {
                                orderStatus = 1;
                            }

                            for (var i = 0; i <= orderStatus; i++) {
                                var element = trackItem.eq(i).addClass('active');
                            }
                        }
                    }
                });
            });

        })(jQuery);
    </script>
@endpush

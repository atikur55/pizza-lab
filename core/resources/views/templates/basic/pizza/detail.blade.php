@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="section--bg pt-80 pb-80">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-12">
                    <div class="pizza-order-wrapper">
                        <div class="pizza-order-wrapper__left">

                            <div class="pizza-details-slider">

                                <div class="single-slide">
                                    <img src="{{ getImage(getFilePath('pizza') . '/' . $pizza->image, getFileSize('pizza')) }}" alt="image">
                                </div>

                                @foreach ($pizza->pizzaGallery as $gallery)
                                    <div class="single-slide">
                                        <img src="{{ getImage(getFilePath('pizza') . '/' . $gallery->image, getFileSize('pizza')) }}" alt="image">
                                    </div>
                                @endforeach
                            </div>

                            <div class="pizza-nav-slider">

                                @if ($pizza->pizzaGallery->count())
                                    <div class="single-slide">
                                        <img src="{{ getImage(getFilePath('pizza') . '/thumb_' . $pizza->image, getFileThumb('pizza')) }}" alt="image">
                                    </div>
                                @endif
                                @foreach ($pizza->pizzaGallery as $gallery)
                                    <div class="single-slide">
                                        <img src="{{ getImage(getFilePath('pizza') . '/thumb_' . $gallery->image, getFileThumb('pizza')) }}" alt="image">
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="pizza-order-wrapper__right">
                            <div class="top">
                                <div class="top__Left">
                                    <h2 class="title">{{ __($pizza->name) }}</h2>
                                    <div class="d-flex align-items-center flex-wrap gap-4">
                                        <div class="ratings">
                                            @php
                                                $star = showPizzaRatings($pizza->avg_rating);
                                                echo $star;
                                            @endphp
                                            ({{ $pizza->reviews->count() }})
                                        </div>
                                        <strong class="price ms-sm-3">{{ $general->cur_sym }}{{ showAmount(@$pizza->pizzaPrice->price) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3">{{ __($pizza->short_description) }}</p>
                            <ul class="ingredients-list mt-3">
                                <li>@lang('Ingredients') : </li>
                                @foreach (json_decode($pizza->ingredients) as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                @endforeach
                            </ul>
                            <ul class="ingredients-list mt-3">
                                <li>@lang('Category') : </li>
                                <li>{{ __(@$pizza->category->name) }}</li>
                            </ul>
                            <hr>
                            <form class="mt-5">
                                <div class="size-select">
                                    <div class="left">
                                        <h6 class="mb-3">@lang('Select Size')</h6>
                                        <div class="size-field">
                                            @foreach ($pizza->pizzaSize as $size)
                                                <div class="pizza-size pizzaSize @if ($loop->first) active @endif" data-size="{{ $size }}">{{ $size->size }}"
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="right">
                                        <h6 class="mb-4">@lang('Total')</h6>
                                        <div class="size-select-field">
                                            <h3 class="total text--base">{{ $general->cur_sym }}{{ showAmount($pizza->pizzaPrice->price) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mt-4 flex-wrap gap-1">
                                    <div class="select-amount me-4">
                                        <input type="text" class="form--control value" value="1">
                                        <button type="button" class="value-btn increment">+</button>
                                        <button type="button" class="value-btn decrement">-</button>
                                    </div>
                                    <button type="button" class="btn btn--base add-to-cart" data-pizza_id="{{ $pizza->id }}">@lang('Add to Cart')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <ul class="nav nav-tabs custom--nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">@lang('Description')</button>
                        </li>
                        @if ($pizza->reviews->count() > 0)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">@lang('Review')</button>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p>@php echo $pizza->description; @endphp </p>
                        </div>
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <div class="review-wrapper">
                                @forelse ($pizza->reviews as $review)
                                    <div class="single-review">
                                        <div class="content">
                                            <h6>{{ __(@$review->user->username) }}</h6>
                                            <div class="ratings">
                                                @for ($i = 1; $i <= $review->stars; $i++)
                                                    <i class="las la-star"></i>
                                                @endfor

                                                @for ($k = 1; $k <= 5 - $review->stars; $k++)
                                                    <i class="lar la-star"></i>
                                                @endfor
                                            </div>
                                            <p class="mt-2">{{ __($review->review_comment) }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="single-review">
                                        <div class="content">
                                            <h6 class="text--danger text-center">{{ __($emptyMessage) }}</h6>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            var valueField = $(".value").val();
            const incrementBtn = $(".increment");
            const decrementBtn = $(".decrement");
            let price;
            let total;
            let size;

            price = $('.pizzaSize').first().data('size').price;

            $('.pizzaSize').on('click', function() {

                $(this).addClass('active');
                $('.pizzaSize').not($(this)).removeClass('active');

                var size = $(this).data('size');
                price = size.price;

                if (price == undefined) {
                    notify('error', 'Something went wrong.');
                } else {
                    var quantity = $('.value').val();
                    total = quantity * price;
                    $('.total').text(`{{ $general->cur_sym }}${parseFloat(total).toFixed(2)}`)
                    $('.price').text(`{{ $general->cur_sym }}${parseFloat(price).toFixed(2)}`)
                }
            });

            $(".increment").on("click", function() {
                size = $('.pizzaSize:checked').val();
                var incrementValue = ++valueField;
                total = price * incrementValue;
                $('.total').text(`{{ $general->cur_sym }}${parseFloat(total).toFixed(2)}`)
                $(".value").val(incrementValue);
            });

            $(".decrement").on("click", function() {
                size = $('.pizzaSize:checked').val();
                if ($(".value").val() <= 1) {
                    $(".value").val(1);
                } else {
                    var decrementValue = --valueField;
                    total = price * decrementValue;
                    $('.total').text(`{{ $general->cur_sym }}${parseFloat(total).toFixed(2)}`)
                    $(".value").val(decrementValue);
                }
            });

            $('.value').on('focusout', function() {
                size = $('.pizzaSize:checked').val();
                total = price * $(this).val();
                $('.total').text(`{{ $general->cur_sym }}${parseFloat(total).toFixed(2)}`)

            })

        })(jQuery);
    </script>
@endpush

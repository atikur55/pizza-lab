@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="section--bg pt-80 pb-80">
        <div class="container">
            <div class="row gy-3">
                <div class="col-xl-3 col-lg-4">
                    <button type="button" class="sidebar-open-btn"><i class="las la-sliders-h text--base me-2"></i>@lang('Filter')</button>

                    <div class="sidebar-overlay">
                        <div class="sidebar" data-simplebar>
                            <button type="button" class="sidebar-close-btn"><i class="las la-times"></i></button>

                            <div class="sidebar-widget">
                                <div class="input-group mb-3">
                                    <input type="text" name="" class="form-control form--control mySearch" placeholder="@lang('Search here')" value="{{ request()->search }}">
                                    <button class="input-group-text bg--base border--base searchBtn px-3 text-white" type="button"><i class="fas fa-search"></i></button>
                                </div>
                            </div>

                            @if (@$categories)
                                <div class="sidebar-widget">
                                    <h6 class="sidebar-widget__title">@lang('Categories')</h6>
                                    <div class="checkbox-wrapper">
                                        <div class="form-check custom--checkbox">
                                            <input class="form-check-input sortCategory" type="checkbox" name="category" value="" id="category0" checked>
                                            <label class="form-check-label" for="category0">@lang('All Categories')</label>
                                        </div>
                                        @foreach ($categories as $category)
                                            <div class="form-check custom--checkbox">
                                                <input class="form-check-input sortCategory" type="checkbox" name="category" value="{{ $category->id }}" id="category{{ $category->id }}">
                                                <label class="form-check-label" for="category{{ $category->id }}">{{ __($category->name) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="sidebar-widget">
                                <h6 class="sidebar-widget__title">@lang('Sort')</h6>
                                <div class="radio-wrapper">
                                    <div class="form-check custom--radio">
                                        <input class="form-check-input sortPizza" type="radio" value="id_desc" name="sort" id="price1" checked>
                                        <label class="form-check-label" for="price1">
                                            @lang('Latest')
                                        </label>
                                    </div>
                                    <div class="form-check custom--radio">
                                        <input class="form-check-input sortPizza" type="radio" value="price_asc" name="sort" id="price2">
                                        <label class="form-check-label" for="price2">
                                            @lang('Low to High')
                                        </label>
                                    </div>
                                    <div class="form-check custom--radio">
                                        <input class="form-check-input sortPizza" type="radio" value="price_desc" name="sort" id="price3">
                                        <label class="form-check-label" for="price3">
                                            @lang('High to Low')
                                        </label>
                                    </div>
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-5">
                                        <input type="text" name="min" class="form--control form-control-sm" placeholder="@lang('Min')">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="max" class="form--control form-control-sm" placeholder="@lang('Max')">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn w-100 h-100 btn--base priceBtn p-0"><i class="las la-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-9 col-lg-8 ps-lg-4 position-relative">
                    <div class="loader-wrapper">
                        <div class="loader"></div>
                    </div>
                    <div class="row gy-4" id="pizzas">
                        @include($activeTemplate . 'pizza.filtered')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let page = null;
            $('.loader-wrapper').addClass('d-none');
            $('.sortCategory, .sortPizza').on('click', function() {
                if ($('#category0').is(':checked')) {
                    $("input[type='checkbox'][name='category']").not(this).prop('checked', false);
                }
                fetchPizza();
            });

            $('.searchBtn').on('click', function() {
                $(this).attr('disabled', 'disabled');
                fetchPizza();
            });

            $('.priceBtn').on('click', function() {
                fetchPizza();
            });

            function fetchPizza() {
                $('.loader-wrapper').removeClass('d-none');
                let data = {};
                data.categories = [];

                $.each($("[name=category]:checked"), function() {
                    if ($(this).val()) {
                        data.categories.push($(this).val());
                    }
                });

                data.search = $('.mySearch').val();
                data.sort = $('.sortPizza:checked').val();
                data.min = $("[name=min]").val();
                data.max = $("[name=max]").val();
                data.categoryId = "{{ @$id }}";

                let url = `{{ route('pizza.filter') }}`;

                if (page) {
                    url = `{{ route('pizza.filter') }}?page=${page}`;
                }

                $.ajax({
                    method: "GET",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#pizzas').html(response);
                        $('.searchBtn').removeAttr('disabled');
                    }
                }).done(function() {
                    $('.loader-wrapper').addClass('d-none')
                });
            }

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                page = $(this).attr('href').split('page=')[1];
                fetchPizza();
            });
        })(jQuery);
    </script>
@endpush

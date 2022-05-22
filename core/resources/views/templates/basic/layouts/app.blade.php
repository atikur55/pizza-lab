<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link rel="icon" type="image/png" href="{{ getImage(getFilePath('logoIcon') . '/favicon.png', '?' . time()) }}" sizes="16x16">
    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lib/simplebar.css') }}">
    <!-- lisghtcase css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">

    @stack('style-lib')

    @stack('style')

</head>

<body>
    @stack('fbComment')
    <div class="preloader">
        <div class="preloader__inner">
            <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}" class="preloader-logo" alt="image">
            <i class="las la-biking preloader-icon"></i>
        </div>
    </div>

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    @yield('app')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp

    @if (@$cookie->data_values->status && !\Cookie::get('gdpr_cookie'))
        <div class="cookie__wrapper">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-10">
                        <span class="txt my-2">
                            <p class="text-white">@php echo @$cookie->data_values->short_desc @endphp</p>
                            <a href="{{ route('cookie.policy') }}" target="_blank" class="text--base">
                                @lang('Read Policy')
                            </a>
                        </span>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn--base acceptPolicy my-2">@lang('Accept')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')
    <!-- slick  slider js -->
    <script src="{{ asset($activeTemplateTrue . 'js/lib/slick.min.js') }}"></script>
    <!-- wow js  -->
    <script src="{{ asset($activeTemplateTrue . 'js/lib/wow.min.js') }}"></script>
    <!-- lightcase js -->
    <script src="{{ asset($activeTemplateTrue . 'js/lib/lightcase.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/lib/simplebar.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>

    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            var url = `{{ route('cookie.accept') }}`;
            $('.acceptPolicy').on('click', function() {
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $('.cookie__wrapper').hide();
                    }
                });
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                matched = event.matches;
                if (matched) {
                    $('body').addClass('dark-mode');
                    $('.navbar').addClass('navbar-dark');
                } else {
                    $('body').removeClass('dark-mode');
                    $('.navbar').removeClass('navbar-dark');
                }
            });

            let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (matched) {
                $('body').addClass('dark-mode');
                $('.navbar').addClass('navbar-dark');
            } else {
                $('body').removeClass('dark-mode');
                $('.navbar').removeClass('navbar-dark');
            }

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');

            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });

        })(jQuery);
    </script>
    
    

</body>

</html>

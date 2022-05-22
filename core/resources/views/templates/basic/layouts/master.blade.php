@extends($activeTemplate.'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')

    @if (!request()->routeIs('home'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    <main class="main-wrapper">

        <section class="section--bg pt-80 pb-80">
            <div class="container">
                <div class="row gy-4">
                    @include($activeTemplate . 'partials.user_sidebar')
                    <div class="col-lg-8 col-xl-9">
                        <div class="sidebar-toggler-wrapper d-lg-none d-inline-block mb-4">
                            <div class="sidebar-toggler">
                                <i class="las la-bars"></i>
                            </div>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include($activeTemplate . 'partials.footer')
@endsection
@push('script')
    <script>
        (function($) {
            "use script";
            getCartCount();

            function getCartCount() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get.cart.count') }}",
                    success: function(response) {
                        $('.cart-count').text(response);
                    }
                });
            }
        })(jQuery);
    </script>
@endpush

@extends($activeTemplate.'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')

    @if (!request()->routeIs('home'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    <main class="main-wrapper">
        @yield('content')
    </main>

    @include($activeTemplate . 'partials.footer')
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";

            getCartCount();

            $(document).on('click', '.add-to-cart', function(e) {
                e.preventDefault();
                var pizzaId = $(this).data('pizza_id');
                var size = $('.pizzaSize.active').data('size');
                var quantity = $('.value').val();
                var user = "{{ Auth::id() }}";
                if (!user) {
                    notify('error', 'Login is required');
                    return false;
                }
                if (size == undefined) {
                    notify('error', 'You must first select a pizza size.');
                    return false;
                }
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    type: "POST",
                    url: "{{ route('user.add.to.cart') }}",
                    data: {
                        pizzaId: pizzaId,
                        size: size,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            getCartCount();
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });

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


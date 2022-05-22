@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="section--bg pt-80 pb-80">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="table-responsive table-responsive--md">
                        <table class="custom--table cart-table table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Size')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Total')</th>
                                    <th>@lang('Remove')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carts as $cart)
                                    <tr>
                                        <td data-label="@lang('Name')">
                                            <h6 class="s-post__title fs--16px">
                                                <a href="{{ route('pizza.detail', [@$cart->pizza->id, slug(@$cart->pizza->name)]) }}" class="pizzaName" data-cart_id="{{ $cart->id }}">{{ @$cart->pizza->name }}</a>
                                            </h6>
                                        </td>
                                        <td data-label="@lang('Size')">
                                            <span class="price">{{ $cart->size }}"</span>
                                        </td>
                                        <td data-label="@lang('Price')">
                                            <span class="price">{{ $general->cur_sym }}{{ showAmount($cart->price) }}</span>
                                        </td>
                                        <td data-label="@lang('Quantity')">
                                            <div class="select-amount style--two mx-auto">
                                                <input type="text" name="quantity" class="form--control value" id="value" value="{{ $cart->quantity }}">
                                                <button type="button" class="value-btn increment">+</button>
                                                <button type="button" class="value-btn decrement">-</button>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Total')">
                                            <span class="subtotal">{{ $general->cur_sym }}{{ getAmount($cart->total) }}</span>
                                        </td>
                                        <td data-label="@lang('Remove')">
                                            <button type="button" class="delete-btn btn btn--danger btn-sm"><i class="las la-times"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text--danger text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-sidebar">
                        <div class="cart-sidebar__header">
                            <h4 class="text-white">@lang('Cart Total')</h4>
                        </div>
                        <div class="cart-sidebar__body">
                            <ul class="caption-list">
                                <li>
                                    <span class="caption">@lang('Subtotal')</span>
                                    <span class="value text-end subtotal-price">{{ getAmount($subtotal) }}</span>
                                </li>
                            </ul>
                            @if ($carts->count())
                            <a href="{{ route('user.checkout') }}" type="submit" class="btn btn--base w-100 mt-4">@lang('Proceed to Checkout')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="removeCartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--base">
                    <strong class="modal-title text-white">@lang('Confirmation Alert!')</strong>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this pizza?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn--base btn-sm remove-product">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use script";
            const incrementBtn = $(".increment");
            const decrementBtn = $(".decrement");
            let currentRow;
            let quantity;

            $('.decrement').on('click',function() {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();
                var incrementValue = --quantity;
                if (quantity > 0) {
                    currentRow.find('input[name="quantity"]').val(incrementValue);
                    cartCalculation(currentRow)
                } else {
                    currentRow.find('input[name="quantity"]').val(1)
                    notify('error', 'You have to order a minimum amount of one.');
                }
            });

            $('.increment').on('click',function() {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();
                var incrementValue = ++quantity;
                currentRow.find('input[name="quantity"]').val(incrementValue);
                cartCalculation(currentRow)
            });


            $('input[name="quantity"]').on('focusout', function() {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();
                if (quantity > 0) {
                    cartCalculation(currentRow)
                } else {
                    currentRow.find('input[name="quantity"]').val(1)
                    cartCalculation(currentRow)
                    notify('error', 'You have to order a minimum amount of one.');
                }
            });

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
            subTotal();

            function subTotal() {
                var totalArr = [];
                var subtotal = 0;
                $('.cart-table tr').each(function(index, tr) {
                    $(tr).find('td').each(function(index, td) {
                        $(td).find('.subtotal').each(function(index, value) {
                            var productPrice = $(value).text();
                            var splitPrice = productPrice.split("{{ $general->cur_sym }}");
                            var price = parseFloat(splitPrice[1]);
                            totalArr.push(price);
                        });
                    });
                });
                for (var i = 0; i < totalArr.length; i++) {
                    subtotal += totalArr[i];
                }
                $('.subtotal-price').text("{{ $general->cur_sym }}" + subtotal.toFixed(2));
            }

            function cartCalculation() {
                var cart_id = currentRow.find('.pizzaName').data('cart_id');
                var quantity = currentRow.find('input[name="quantity"]').val();
                var pizzaPrice = currentRow.find('.price').text();
                var splitPrice = pizzaPrice.split("{{ $general->cur_sym }}");
                var price = parseFloat(splitPrice[1]);
                var totalPrice = quantity * price;
                currentRow.find('.subtotal').text("{{ $general->cur_sym }}" + totalPrice.toFixed(2));

                subTotal();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    method: "POST",
                    url: "{{ route('user.update-cart') }}",
                    data: {
                        cart_id: cart_id,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            }

            let removeableItem = null;
            let modal = $('#removeCartModal');

            $('.delete-btn').on('click', function() {
                removeableItem = $(this).closest("tr");
                modal = $('#removeCartModal');
                modal.modal('show');
            });

            $(".remove-product").on('click', function() {
                let cart_id = removeableItem.find('.pizzaName').data('cart_id');
                $('.coupon-show').addClass('d-none')
                $('.total-show').addClass('d-none')
                $('.coupon').val('');
                $.ajax({
                    method: "GET",
                    url: "{{ route('user.delete-cart') }}",
                    data: {
                        cart_id: cart_id
                    },
                    success: function(response) {
                        if (response.success) {
                            removeableItem.remove();
                            getCartCount();
                            subTotal();
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

@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="section--bg pt-80 pb-80">
        <div class="container">
            <form action="{{ route('user.checkout.order') }}" method="POST">
                @csrf
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="custom--card bg-white">
                            <div class="card-body py-5 px-4">
                                <div class="row gy-3">
                                    <h4 class="mb-3">@lang('Personal Details')</h4>
                                    <div class="col-lg-6">
                                        <label>@lang('First Name')</label>
                                        <input type="text" name="firstname" class="form--control" value="{{ auth()->user()->firstname }}" readonly>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>@lang('Last Name')</label>
                                        <input type="text" name="lastname" class="form--control" value="{{ auth()->user()->lastname }}" readonly>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>@lang('Email')</label>
                                        <input type="email" name="email" class="form--control" value="{{ auth()->user()->email }}" readonly>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>@lang('Phone')</label>
                                        <input type="tel" name="mobile" class="form--control" value="{{ auth()->user()->mobile }}" readonly>
                                    </div>
                                </div>

                                <h4 class="mb-3 mt-5">@lang('Billing Details')</h4>

                                <div class="row gy-3">

                                    <div class="col-lg-12 ,n-3">

                                        <label>@lang('Shipping Method')<span class="text--danger">*</span></label>
                                        <select name="shipping_method" class="select shipping-type" required>
                                            <option value="" selected disabled>@lang('Select One')</option>
                                            @foreach ($shippingMethod as $method)
                                                <option value="{{ $method->id }}" data-charge="{{ getAmount($method->price) }}">{{ __($method->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-12">
                                        <label>@lang('Shipping Address')<span class="text--danger">*</span></label>
                                        <textarea type="text" name="address" class="form--control" placeholder="@lang('Receiver\'s full address')" value="{{ old('address') }}" required></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @php
                            $coupon = session()->get('coupon');
                            $discount = $coupon['discount'] ?? 0;
                        @endphp

                        <div class="card custom--card bg-white">
                            <div class="card-body">
                                <h4 class="coupon-box mt-3">@lang('Apply Coupon')</h4>
                                <div class="input-group coupon-box my-3">
                                    <input type="text" name="coupon" class="form-control form--control" placeholder="@lang('Coupon Code')" value="{{ @$coupon['code'] }}">

                                    <button type="button" class="input-group-text btn--danger remove-btn @if (!$coupon) d-none @endif left-radius border-0">@lang('Remove')</button>

                                    <button type="button" class="input-group-text btn--base apply-coupon @if ($coupon) d-none @endif border-0">@lang('Apply')</button>
                                </div>

                                <ul class="caption-list mt-4">
                                    <li>
                                        <span class="caption">@lang('Subtotal')</span>
                                        <span class="value text-end">{{ $general->cur_sym }}{{ showAmount($subtotal) }}</span>
                                    </li>

                                    <li>
                                        <span class="caption">@lang('Shipping Charge')</span>
                                        <span class="value text-end shipping-charge">{{ $general->cur_sym }}0.00</span>
                                    </li>
                                    <li>
                                        <span class="caption">@lang('Discount')</span>
                                        <span class="value text-end discount">{{ $general->cur_sym }}{{ showAmount($discount) }}</span>
                                    </li>

                                    <li>
                                        <span class="caption">@lang('Grand Total')</span>
                                        <span class="value text-end fw-bold text--base grand-total">{{ $general->cur_sym }}{{ showAmount($subtotal - $discount) }}</span>
                                    </li>
                                </ul>



                                <div class="payment-methods mt-4">
                                    <h4>@lang('Payment methods')<span class="text--danger">*</span></h4>
                                    <hr>
                                    <div class="payment-methods d-flex mt-3 flex-wrap" style="gap:10px">
                                        <div class="d-flex flex-wrap" style="gap:25px">
                                            <div class="form-check custom--radio">
                                                <input id="onlinePayment" type="radio" class="form-check-input" name="payment_type" value="1">
                                                <label for="onlinePayment" class="form-check-label">@lang('Online Payment')</label>
                                            </div>

                                            <div class="form-check custom--radio">
                                                <input id="cashOnDelivery" type="radio" name="payment_type" class="form-check-input" value="2">
                                                <label for="cashOnDelivery" class="form-check-label">@lang('Cash On Delivery')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn--base w-100 mt-4">@lang('Checkout')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <div class="modal fade" id="removeCouponModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--base">
                    <strong class="modal-title text-white">@lang('Confirmation Alert!')</strong>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this coupon?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn--base btn-sm remove-coupon">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        (function($) {
            'use script';
            let subtotal = parseFloat("{{ $subtotal }}");
            let shippingCharge = 0;
            let discount = 0;
            let grandTotal = 0;
            let curSymbol = `{{ $general->cur_sym }}`;


            $('.apply-coupon').on('click', function(e) {
                let coupon = $('[name=coupon]').val();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('user.coupon.apply') }}",
                    data: {
                        coupon: coupon
                    },
                    success: function(response) {
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            notify('success', response.success);
                            $('.apply-coupon').hide();
                            $('.remove-btn').removeClass('d-none');
                        }
                        discount = response.coupon.discount;
                        setGrandTotal();
                    }
                });
            });

            $('.remove-btn').on('click', function() {
                removeableItem = $(this).closest("tr");
                modal = $('#removeCouponModal');
                modal.modal('show');
            });

            $('.remove-coupon').on('click', function() {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    method: "POST",
                    url: "{{ route('user.remove.coupon') }}",
                    success: function(response) {
                        notify('success', response.success);
                        discount = 0;

                        $('[name=coupon]').val('');
                        $('.apply-coupon').show();
                        $('.remove-btn').addClass('d-none');

                        setGrandTotal();
                    }
                });

                modal.modal('hide');
            });

            $('.shipping-type').on('change', function() {
                shippingCharge = Number($(this).find(':selected').data('charge')).toFixed(2);
                $('.shipping-charge').text(`${curSymbol}${shippingCharge}`);
                setGrandTotal();
            });

            function setGrandTotal() {
                grandTotal = Number(subtotal) + Number(shippingCharge) - Number(discount);

                $('.discount').text(`${curSymbol}${discount.toFixed(2)}`);
                $('.grand-total').text(`${curSymbol}${grandTotal.toFixed(2)}`);
            }

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .left-radius {
            border-radius: 0 5px 5px 0 !important;
        }

    </style>
@endpush

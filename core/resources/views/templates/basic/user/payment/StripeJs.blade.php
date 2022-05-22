@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="title">@lang('Stripe Storefront')</h5>
        </div>
        <div class="card-body p-5">
            <form action="{{ $data->url }}" method="{{ $data->method }}">
                <h5>@lang('You have to pay') {{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</h5>
                <script src="{{ $data->src }}" class="stripe-button" @foreach ($data->val as $key => $value) data-{{ $key }}="{{ $value }}" @endforeach>
                </script>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base w-100 mt-3");
        })(jQuery);
    </script>
@endpush

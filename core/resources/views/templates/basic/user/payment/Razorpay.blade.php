@extends($activeTemplate.'layouts.master')

@section('content')
<div class="card custom--card">
    <div class="card-header">
        <h5 class="title">@lang('Razorpay')</h5>
    </div>
    <div class="card-body p-5">
        <h5>@lang('You have to pay') {{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</h5>
         <form action="{{$data->url}}" method="{{$data->method}}">
            <input type="hidden" custom="{{$data->custom}}" name="hidden">
            <script src="{{$data->checkout_js}}"
                    @foreach($data->val as $key=>$value)
                    data-{{$key}}="{{$value}}"
                @endforeach >
            </script>
        </form>
    </div>
</div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("mt-4 btn btn--base w-100");
        })(jQuery);
    </script>
@endpush

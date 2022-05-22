@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="title">@lang('Paystack')</h5>
        </div>
        <div class="card-body p-5">
            <form action="{{ route('ipn.' . $deposit->gateway->alias) }}" method="POST" class="text-center">
                @csrf

                <h5>@lang('You have to pay') {{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</h5>

                <button type="button" class="btn btn--base w-100 mt-3" id="btn-confirm">@lang('Pay Now')</button>
                <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}" data-email="{{ $data->email }}" data-amount="{{ round($data->amount) }}" data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}" data-custom-button="btn-confirm">
                </script>
            </form>
        </div>
    </div>
@endsection

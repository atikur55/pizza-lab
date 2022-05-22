@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="card custom--card">
        <div class="card-header card-header-bg">
            <h5 class="title">{{ __($pageTitle) }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 text-center">
                        @lang('Please pay') <b class="text--base">{{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }} </b> @lang('for successful payment')
                        </p>
                        <h4 class="mb-2 text-center">@lang('Please follow the instruction below')</h4>

                        <p class="my-2 text-center">@php echo  $data->gateway->description @endphp</p>

                    </div>

                    <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}"></x-viser-form>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

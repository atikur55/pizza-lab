@extends($activeTemplate.'layouts.master')
@section('content')
    <form action="" class="mb-3">
        <div class="d-flex justify-content-end flex-wrap gap-4">
            <div class="input-group w-auto">
                <input type="text" name="search" value="{{ request()->search }}" placeholder="@lang('TRX No.')" class="form--control">
                <button class="input-group-text btn--base border-0"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="table-responsive table-responsive--md">

        <table class="custom--table table">
            <thead>
                <tr>
                    <th>@lang('TRX No.')</th>
                    <th>@lang('Order NO')</th>
                    <th>@lang('Transacted')</th>
                    <th>@lang('Amount')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $trx)
                    <tr>
                        <td data-label="@lang('TRX No.')">
                            <strong>{{ $trx->trx }}</strong>
                        </td>

                        <td data-label="@lang('Order NO')">
                            <strong>{{ @$trx->order->order_no }}</strong>
                        </td>

                        <td data-label="@lang('Transacted')">
                            {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                        </td>

                        <td data-label="@lang('Amount')" class="budget">
                            <span class="fw-bold">
                                {{ showAmount($trx->amount) }} {{ $general->cur_text }}
                            </span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $payments->links() }}
@endsection

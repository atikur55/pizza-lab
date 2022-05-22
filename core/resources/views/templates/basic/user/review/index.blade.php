@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="table-responsive table-responsive--md mt-5">
        <table class="table custom--table">
          <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Image')</th>
                <th>@lang('Price')</th>
                <th>@lang('Rating')</th>
                <th>@lang('Action')</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pizzas as $pizza)
                <tr>
                    <td data-label="@lang('Name')">{{ __($pizza->name) }}</td>
                    <td data-label="@lang('Image')">
                        <img src="{{ getImage(getFilePath('pizza').'/'. $pizza->image,getFileSize('pizza'))}}" alt="@lang('image')" class="show-img" width="40px">
                    </td>
                    <td data-label="@lang('Price')" class="text--base">
                        <strong>{{ $general->cur_sym }}{{ showAmount(@$pizza->pizzaPrice->price) }}</strong>
                    </td>
                    <td data-label="@lang('Rating')">
                        <div class="ratings">
                            @php
                                $star = showPizzaRatings($pizza->avg_rating);
                                echo $star;
                            @endphp
                        </div>
                    </td>
                    <td data-label="@lang('Action')">
                        <a href="{{ route('user.review.create',[$pizza->id,slug($pizza->name)]) }}" class="btn btn-sm btn--base @if($pizza->reviews->count() > 0) disabled @endif" data-bs-toggle="tooltip" data-bs-position="top" title="@lang('Add Review')">
                            <i class="las la-star-of-david"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="100%" class="text--danger justify-content-center text-center">{{ __($emptyMessage) }}</td>
                </tr>
                @endforelse
          </tbody>
        </table>
      </div>
      {{ $pizzas->links() }}
@endsection

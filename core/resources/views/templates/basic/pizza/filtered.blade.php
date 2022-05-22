@php
$content = getContent('empty_message.content', true);
@endphp

@forelse ($pizzas as $pizza)
    <div class="col-xl-4 col-sm-6">
        <div class="pizza-item style--two has--link">
            <a href="{{ route('pizza.detail', [$pizza->id, slug($pizza->name)]) }}" class="item--link"></a>
            <div class="pizza-item__thumb">
                <img src="{{ getImage(getFilePath('pizza') . '/thumb_' . $pizza->image, getFileThumb('pizza')) }}" alt="image">
            </div>
            <div class="pizza-item__content">
                <div class="left">
                    <h3 class="title">{{ __($pizza->name) }}</h3>
                    <strong class="fs--14px">{{ __(@$pizza->category->name) }}</strong>
                    <div class="ratings">
                        @php
                            $star = showPizzaRatings($pizza->avg_rating);
                            echo $star;
                        @endphp
                    </div>
                </div>
                <div class="right">
                    <h4 class="price">{{ $general->cur_sym }}{{ showAmount(@$pizza->pizzaPrice->price) }}</h4>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-xl-12 col-md-12 col-sm-12 text-center">
        <img src="{{ getImage('assets/images/frontend/empty_message/' . @$content->data_values->image, '400x400') }}" alt="image">
    </div>
@endforelse
{{ $pizzas->links() }}

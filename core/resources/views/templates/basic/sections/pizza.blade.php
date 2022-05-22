@php
$pizzaContent = getContent('pizza.content', true);
$pizzas = App\Models\Pizza::active()
    ->latest()
    ->with('pizzaPrice', 'category')
    ->where('featured', 1)
    ->take(9)
    ->get();
@endphp

<section class="section--bg pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <div class="section-top-title"><span>{{ __(@$pizzaContent->data_values->heading) }}</span></div>
                    <h2 class="section-title">{{ __(@$pizzaContent->data_values->subheading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($pizzas as $pizza)
                <div class="col-xl-4 col-md-6">
                    <div class="pizza-item has--link">
                        <a href="{{ route('pizza.detail', [$pizza->id, slug($pizza->name)]) }}" class="item--link"></a>
                        <div class="pizza-item__thumb">
                            <img src="{{ getImage(getFilePath('pizza') . '/thumb_' . $pizza->image, getFileThumb('pizza')) }}" alt="image">
                        </div>
                        <div class="pizza-item__content">
                            <div class="left">
                                <h3 class="title">{{ __($pizza->name) }}</h3>
                                <strong>@lang('Category') : {{ __(@$pizza->category->name) }}</strong>
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
            @endforeach
        </div>
    </div>
</section>

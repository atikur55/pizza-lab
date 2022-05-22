@php
$category = getContent('category.content', true);
$categories = App\Models\Category::active()->where('featured', 1)->latest()->get();
@endphp
<section class="position-relative z-index-2 pt-80 pb-80">
    <div class="bg_img pattern-bg" style="background-image: url({{asset($activeTemplateTrue.'images/bg/pattern-bg.png')}})"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <div class="section-top-title"><span>{{ __(@$category->data_values->heading) }}</span></div>
                    <h2 class="section-title">{{ __(@$category->data_values->subheading) }}</h2>
                </div>
            </div>
        </div>
        <div class="category-slider">
            @foreach ($categories as $category)
                <div class="single-slide">
                    <div class="category-item">
                        <div class="category-item__thumb">
                            <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}" alt="@lang('image')">
                        </div>
                        <div class="category-item__content">
                            <h3 class="title">{{ __($category->name) }}</h3>
                            <a href="{{ route('pizza.category', [$category->id, slug($category->name)]) }}" class="btn btn--capsule category-item__btn">@lang('Order Now')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

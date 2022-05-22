@php
    $banner = getContent('banner.content',true);
@endphp
<section class="hero-section bg_img" style="background-image: url('{{ getImage('assets/images/frontend/banner/'.@$banner->data_values->image,'1920x792') }}');">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-7 col-lg-8">
                <span class="top-title text-white">{{ __(@$banner->data_values->title) }}</span>
                <h2 class="hero-section__title">{{ __(@$banner->data_values->subtitle) }}</h2>
                <a href="{{ @$banner->data_values->button_url }}" class="btn btn--dark mt-3">{{ __(@$banner->data_values->button) }}</a>
            </div>
        </div>
    </div>
</section>

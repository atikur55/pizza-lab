@php
$cta = getContent('cta.content',true);
@endphp
<section class="pt-80 pb-80 section--bg2 position-relative z-index-2">
    <div class="bg_img pattern-bg style--two"
        style="background-image: url('{{ getImage('assets/images/frontend/cta/'.@$cta->data_values->background_image,'1920x625') }}');">
    </div>
    <div class="container">
        <div class="row gy-4 align-items-center justify-content-between">
            <div class="col-lg-6 text-lg-start text-center">
                <div class="section-top-title style--two"><span>{{ __(@$cta->data_values->heading) }}</span></div>
                <h2 class="section-title text-white">{{ __(@$cta->data_values->subheading) }}</h2>
                <p class="text-white mt-3">{{ __(@$cta->data_values->short_description) }}</p>
                <a href="{{ @$cta->data_values->button_url }}" class="btn btn--base mt-4">{{ __(@$cta->data_values->button) }}</a>
            </div>
            <div class="col-xl-4 col-lg-5 text-lg-end text-center">
                <img src="{{ getImage('assets/images/frontend/cta/'.@$cta->data_values->image,'400x340') }}" alt="image">
            </div>
        </div>
    </div>
</section>
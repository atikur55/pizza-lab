@php
$chooseContent = getContent('why_choose_us.content', true);
$contents = getContent('why_choose_us.element', false, null, true);
$contact = getContent('contact_us.content', true);
@endphp

<section class="pt-80 pb-80">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-xl-6">
                <div class="choose-content">
                    <div class="section-header">
                        <div class="section-top-title style--two">
                            <span>{{ __(@$chooseContent->data_values->heading) }}</span>
                        </div>
                        <h2 class="section-title">{{ __(@$chooseContent->data_values->subheading) }}</h2>
                    </div>
                    <p>{{ __(@$chooseContent->data_values->short_description) }}</p>
                    <div class="row gy-4 mt-2">
                        @foreach ($contents as $content)
                            <div class="col-md-4">
                                <div class="choose-item">
                                    <div class="choose-item__icon">
                                        <img src="{{ getImage('assets/images/frontend/why_choose_us/' . @$content->data_values->icon_image, '50x50') }}" alt="image">
                                    </div>
                                    <p>{{ __(@$content->data_values->title) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex align-items-center mt-5 flex-wrap">
                        <a href="{{ @$chooseContent->data_values->button_url }}" class="btn btn--dark me-4">{{ __(@$chooseContent->data_values->button) }}</a>
                        <a href="tel:{{ @$contact->data_values->contact_number }}" class="call-btn">
                            <i class="las la-phone-volume"></i>
                            <span>{{ @$contact->data_values->contact_number }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 text-xl-end text-center">
                <img src="{{ getImage('assets/images/frontend/why_choose_us/' . @$chooseContent->data_values->image, '454x426') }}" alt="image">
            </div>
        </div>
    </div>
</section>

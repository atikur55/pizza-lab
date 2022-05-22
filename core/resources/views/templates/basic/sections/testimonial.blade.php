@php
    $testimonialContent = getContent('testimonial.content',true);
    $testimonials = getContent('testimonial.element',false,null,true);
@endphp

<section class="testimonial-section pt-80 pb-80">
    <div class="testimonial-bg bg_img" style="background-image: url('{{ getImage('assets/images/frontend/testimonial/'.@$testimonialContent->data_values->image,'900x600') }}');"></div>
    <div class="container-fluid">
        <div class="row gy-5 justify-content-between">
            <div class="col-xl-5 col-lg-6">
                <div class="section-header text-center">
                    <div class="section-top-title"><span>{{ __(@$testimonialContent->data_values->heading) }}</span></div>
                    <h2 class="section-title text-white">{{ __(@$testimonialContent->data_values->subheading) }}</h2>
                </div>
                <div class="testimonial-slider">
                    @foreach ($testimonials as $testimonial)         
                    <div class="single-slide">
                        <div class="testimonial-item">
                            <i class="fas fa-quote-right"></i>
                            <p class="testimonial-details">{{ __(@$testimonial->data_values->short_description) }}</p>
                            <div class="thumb">
                                <img src="{{ getImage('assets/images/frontend/testimonial/'.@$testimonial->data_values->user_image,'80x80') }}" alt="image">
                            </div>
                            <h6 class="text-white mt-3">{{ __(@$testimonial->data_values->user_name) }}</h6>
                            <p class="text--base">{{ __(@$testimonial->data_values->user_designation) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="video-area">
                    <a href="{{ @$testimonialContent->data_values->video_link }}" data-rel="lightcase:myCollection"
                        class="video-icon">
                        <i class="las la-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

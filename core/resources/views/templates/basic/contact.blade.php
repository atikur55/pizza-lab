@php
$contact = getContent('contact_us.content', true);
@endphp
@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="contact-info">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="content">
                            <h6 class="title mb-1">@lang('Office Address')</h6>
                            <p>{{ __(@$contact->data_values->contact_address) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="content">
                            <h6 class="title mb-1">@lang('Email Address')</h6>
                            <p><a href="mailto:{{ __(@$contact->data_values->email_address) }}">{{ __(@$contact->data_values->email_address) }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <div class="icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="content">
                            <h6 class="title mb-1">@lang('Phone Number')</h6>
                            <p><a href="tel:{{ __(@$contact->data_values->contact_number) }}">{{ __(@$contact->data_values->contact_number) }}</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center gy-4 mt-5">
                <div class="col-lg-7 mb-4 text-center">
                    <h2 class="mb-2">{{ __(@$contact->data_values->title) }}</h2>
                    <p>{{ __(@$contact->data_values->short_details) }}</p>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="" class="contact-form verify-gcaptcha p-sm-4 b-radius--5 border p-3">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-lg-6">
                                <label>@lang('Full Name')</label>
                                <div class="custom-icon-field">
                                    <input type="text" name="name" class="form--control" placeholder="@lang('Name')" value="@if(auth()->user()){{ auth()->user()->fullname }}@else{{ old('name') }}@endif" @if (auth()->user()) readonly @endif required>
                                    <i class="fas fa-user-alt"></i>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label>@lang('Email Address')</label>
                                <div class="custom-icon-field">
                                    <input type="email" name="email" class="form--control" placeholder="@lang('Email')" value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif" @if (auth()->user()) readonly @endif required>
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label>@lang('Subject')</label>
                                <div class="custom-icon-field">
                                    <input type="text" name="subject" class="form--control" placeholder="@lang('Subject')" value="{{ old('subject') }}">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label>@lang('Message')</label>
                                <div class="custom-icon-field">
                                    <textarea name="message" class="form--control" placeholder="@lang('Write Your Message')">{{ old('message') }}</textarea>
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                            </div>
                            <x-captcha></x-captcha>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--base w-100">@lang('Send Message')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="map-area ps-lg-4">
                        <iframe src="https://maps.google.com/maps?q={{ __(@$contact->data_values->latitude) }},{{ __(@$contact->data_values->longitude) }}&hl=es;z=14&amp;output=embed"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

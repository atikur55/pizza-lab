@php
$register = getContent('register.content', true);
$policyPages = getContent('policy_pages.element', false, null, true);
@endphp
@extends($activeTemplate.'layouts.app')
@section('app')
    <section class="account-section style--two">
        <div class="left bg_img" style="background-image: url('{{ getImage('assets/images/frontend/register/' . @$register->data_values->image, '960x970') }}');">
            <div class="left__inner text-center">
                <a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}" alt="image"></a>
                <h3 class="title mt-5 text-white">@lang('Hello! Welcome to') {{ $general->site_name }}</h3>
                <a href="{{ route('user.login') }}" class="btn btn--base mt-5">@lang('Login Account')</a>
            </div>
        </div>
        <div class="right">
            <div class="right__inner">
                <div class="row">
                    <div class="col-xxl-8 col-xl-10">
                        <h3 class="title mb-2">{{ __(@$register->data_values->heading) }}</h3>
                        <p>{{ __(@$register->data_values->subheading) }}</p>
                    </div>
                </div>
                <form class="account-form verify-gcaptcha mt-4" action="{{ route('user.register') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>@lang('Username')</label>
                            <div class="custom-icon-field">
                                <input type="text" name="username" value="{{ old('username') }}" class="form--control checkUser" placeholder="@lang('Username')" required>
                                <i class="fas fa-user"></i>
                            </div>
                            <small class="text-danger usernameExist"></small>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('Email')</label>
                            <div class="custom-icon-field">
                                <input type="email" class="form--control checkUser" name="email" value="{{ old('email') }}" placeholder="@lang('Email Address')" required>
                                <i class="lar la-envelope"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('Password')</label>
                            <div class="custom-icon-field hover-input-popup">
                                <input type="password" name="password" id="password-seen" class="form--control" placeholder="@lang('Password')">
                                <i class="fas fa-lock"></i>
                                <span class="input-eye"><i class="far fa-eye"></i></span>
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('Confirm Password')</label>
                            <div class="custom-icon-field">
                                <input type="password" name="password_confirmation" class="form--control" placeholder="@lang('Password')" required>
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('Country')</label>
                            <div class="custom-icon-field">
                                <select class="select" name="country">
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                            {{ __($country->country) }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="las la-globe"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('Phone')</label>
                            <div class="input-group">

                                <span class="input-group-text mobile-code" id="basic-addon1"></span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                                <input type="number" name="mobile" class="form--control checkUser" placeholder="@lang('Phone Number')" value="{{ old('mobile') }}" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <small class="text-danger mobileExist"></small>
                        </div>
                        <x-captcha></x-captcha>
                        @if($general->agree)
                        <div class="col-lg-12">
                            <div class="form-check custom--checkbox">
                                <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                <label class="form-check-label" for="agree">
                                    @lang('I agree with')
                                    @foreach ($policyPages as $policy)
                                        <a href="{{ route('policy.pages', [slug(@$policy->data_values->title), $policy->id]) }}" class="text--base">
                                            {{ __(@$policy->data_values->title) }} @if (!$loop->last)
                                                ,
                                            @endif
                                        </a>
                                    @endforeach
                                </label>
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Create an Account')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h6>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="text-center">@lang('You already have an account please Login ')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input',function(){
                secure_password($(this));
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
            $('.input-eye i').on('click', function() {
                if (localStorage.clickcount === undefined) {
                    localStorage.clickcount = 1;
                    document.getElementById("password-seen").setAttribute("type", "text");
                    $(this).removeClass('active');
                } else {
                    document.getElementById("password-seen").setAttribute("type", "password");
                    $(this).addClass('active');
                    localStorage.clear();
                }
            });
        })(jQuery);
    </script>
@endpush

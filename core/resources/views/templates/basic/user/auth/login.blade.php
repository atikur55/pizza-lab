@php
    $login = getContent('login.content',true);
@endphp
@extends($activeTemplate.'layouts.app')
@section('app')

<section class="account-section">
    <div class="left bg_img" style="background-image: url('{{ getImage('assets/images/frontend/login/'.@$login->data_values->image,'960x970') }}');">
        <div class="left__inner text-center">
            <a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon').'/logo.png', '?'.time()) }}" alt="image"></a>
            <h3 class="title text-white mt-5">@lang('Hello! Welcome to') {{ $general->site_name }}</h3>
            <a href="{{ route('user.register') }}" class="btn btn--base mt-5">@lang('Create Account')</a>
        </div>
    </div>
    <div class="right">
        <div class="right__inner">
            <div class="account-form mx-auto">
                    <h3 class="title mb-2">{{ __(@$login->data_values->heading) }}</h3>
                    <p>{{ __(@$login->data_values->subheading) }}</p>
            </div>
            <form class="account-form mx-auto mt-4 verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                @csrf
                <div class="mb-3">
                    <label>@lang('Username or Email')</label>
                    <div class="custom-icon-field">
                        <input type="text" name="username" class="form--control" placeholder="@lang('Username or Email')" value="{{ old('username') }}" required>
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <label>@lang('Password')</label>
                    <div class="custom-icon-field">
                        <input type="password" name="password" id="password-seen" class="form--control" placeholder="@lang('Password')" required>
                        <i class="fas fa-lock"></i>
                        <span class="input-eye"><i class="far fa-eye"></i></span>
                    </div>
                </div>
                <x-captcha></x-captcha>
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="form-check custom--checkbox me-4">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            @lang('Remember Me')
                        </label>
                    </div>
                    <a href="{{ route('user.password.request') }}" class="text--base">@lang('Forget Your Password')?</a>
                </div>
                <button type="submit" id="recaptcha" class="btn btn--base mt-4 w-100">@lang('Login Now')</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('script')
    <script>
        (function ($) {
            "use script";
            $('.input-eye i').on('click', function(){
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
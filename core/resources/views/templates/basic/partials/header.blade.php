@php
$contact = getContent('contact_us.content', true);
@endphp
<div class="header__top custom-dark">
    <div class="container">
        <div class="header__wrapper d-flex justify-content-between flex-wrap py-2">
            <div class="left">
                <a href="tel:{{ @$contact->data_values->contact_number }}" class="text-white">@lang('Tel'): {{ @$contact->data_values->contact_number }}</a>
            </div>
            <div class="right text-white">
                <ul class="header-links d-flex flex-wrap">
                    <li>
                        <a href="{{ route('track.order') }}" class="{{ menuActive('track.order') }}"><i class="las la-sliders-h"></i> @lang('Track')</a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('user.home') }}" class="{{ menuActive('user.home') }}"><i class="las la-tachometer-alt"></i> @lang('Dashboard')</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('user.login') }}" class="d-inline-block">@lang('Login')</a> / <a href="{{ route('user.register') }}" class="d-inline-block">@lang('Register')</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="header__bottom">
    <div class="container">
        <nav class="navbar navbar-expand-xl align-items-center">
            <a class="site-logo site-title" href="{{ route('home') }}">
                <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}" alt="logo">
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-toggle"></span>
            </button>
            <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                <ul class="navbar-nav main-menu m-auto">
                    <li>
                        <a href="{{ route('home') }}" class="{{ menuActive('home') }}">@lang('Home')</a>
                    </li>
                    <li>
                        <a href="{{ route('pizza.all') }}" class="{{ menuActive('pizza.all') }}">@lang('Pizza')</a>
                    </li>
                    @foreach($pages as $k => $data)
                    <li>
                        <a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a>
                    </li>
                    @endforeach
                    <li>
                        <a href="{{ route('blog') }}" class="{{ menuActive('blog') }}">@lang('Blog')</a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}" class="{{ menuActive('contact') }}">@lang('Contact')</a>
                    </li>

                </ul>
                <div class="nav-right justify-content-xl-end align-items-center">
                    <div class="position-relative d-xl-block d-none">
                        <a href="javascript:void(0)" class="search-toggler lh-1 me-2 mt-2 px-3 py-2 text-white"></a>
                        <form class="header-search-form" action="{{ route('pizza.all') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" autocomplete="off" class="form--control" placeholder="@lang('Search for your favourite pizza')">
                                <button type="submit" class="header-search-form__btn text--base"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a href="{{ route('user.cart') }}" class="cart-btn">
                        <i class="las la-shopping-cart"></i>
                        <span class="cart-btn-amount cart-count">0</span>
                    </a>
                    <select class="language langSel">
                        @foreach ($language as $item)
                            <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>
                                {{ __($item->name) }}
                            </option>
                        @endforeach
                    </select>
                    <form class="header-search-form d-xl-none mt-4" action="{{ route('pizza.all') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" autocomplete="off" class="form--control" placeholder="@lang('Search for your favourite pizza')">
                            <button type="submit" class="header-search-form__btn text--base"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</div>

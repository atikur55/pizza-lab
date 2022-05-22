<div class="col-lg-4 col-xl-3">
    <div class="user-sidebar-overlay">
        <div class="user-sidebar bg-white">
            <button class="btn-close user-sidebar-close d-lg-none"></button>
            <ul class="user-menu">
                <li class="{{ menuActive('user.home') }}">
                    <a href="{{ route('user.home') }}"><i class="las la-home"></i>@lang('Dashboard')</a>
                </li>
                <li class="{{ menuActive('user.order.*') }}">
                    <a href="{{ route('user.order.history') }}"><i class="las la-list-ul"></i>@lang('My Orders')</a>
                </li>
                <li class="{{ menuActive('user.payments') }}">
                    <a href="{{ route('user.payments') }}"><i class="las la-money-bill-wave"></i>@lang('Payment History')</a>
                </li>
                <li class="{{ menuActive('user.review.*') }}">
                    <a href="{{ route('user.review.pizzas') }}"><i class="las la-star"></i>@lang('Review Pizza')</a>
                </li>
                <li class="{{ menuActive('ticket*') }}">
                    <a href="{{ route('ticket') }}"><i class="las la-ticket-alt"></i>@lang('Support Tickets')</a>
                </li>
                <li class="{{ menuActive('user.profile.setting') }}">
                    <a href="{{ route('user.profile.setting') }}"><i class="las la-user-alt"></i>@lang('Profile Setting')</a>
                </li>
                <li class="{{ menuActive('user.change.password') }}">
                    <a href="{{ route('user.change.password') }}"><i class="las la-unlock"></i>@lang('Change Password')</a>
                </li>
                <li>
                    <a href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> @lang('Logout')</a>
                </li>
            </ul>
        </div>
    </div>
</div>

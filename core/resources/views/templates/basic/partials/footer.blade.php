@php
$policyPages = getContent('policy_pages.element',false,null,true);
@endphp
<footer class="footer-section">
    <div class="footer-section__top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ getImage(getFilePath('logoIcon').'/logo.png', '?'.time()) }}" alt="image">
                    </a>
                    <ul class="footer-inline-link justify-content-center mt-4">
                        @foreach ($policyPages as $policy)
                        <li><a href="{{ route('policy.pages',[slug(@$policy->data_values->title),$policy->id]) }}">{{ __(@$policy->data_values->title) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-section__bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="text-white">@lang('Copyright') &copy; {{ $general->site_name }} @php echo date('Y') @endphp . @lang('All rights reserved.')</p>
                </div>
            </div>
        </div>
    </div>
</footer>
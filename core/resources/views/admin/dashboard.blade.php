@extends('admin.layouts.app')

@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-warning mb-3 text-white">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version') {{ json_decode($general->sys_version)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->sys_version)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border--primary border" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--primary has-link box--shadow2 overflow-hidden">
                <a href="{{ route('admin.users.all') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-users f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Total Users')</span>
                            <h2 class="text-white">{{ $widget['total_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--success has-link box--shadow2">
                <a href="{{ route('admin.users.active') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-user-check f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Active Users')</span>
                            <h2 class="text-white">{{ $widget['verified_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--danger has-link box--shadow2">
                <a href="{{ route('admin.users.email.unverified') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="lar la-envelope f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Email Unverified Users')</span>
                            <h2 class="text-white">{{ $widget['email_unverified_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--red has-link box--shadow2">
                <a href="{{ route('admin.users.mobile.unverified') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-comment-slash f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Mobile Unverified Users')</span>
                            <h2 class="text-white">{{ $widget['mobile_unverified_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-pizza-slice overlay-icon text--primary"></i>
                <div class="widget-two__icon b-radius--5 border--primary text--primary border">
                    <i class="las la-pizza-slice"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $total['pizza'] }}</h3>
                    <p>@lang('Total Pizza')</p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-hand-holding-usd overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 border--success text--success border">
                    <i class="las la-hand-holding-usd"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($order['total_sale_amount']) }}</h3>
                    <p>@lang('Total Sold')</p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-spinner overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 border--warning text--warning border">
                    <i class="las la-spinner"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($order['pending_amount']) }}</h3>
                    <p>@lang('Total Pending Amount')</p>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-times-circle overlay-icon text--danger"></i>
                <div class="widget-two__icon b-radius--5 border--danger text--danger border">
                    <i class="las la-times-circle"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($order['cancel_amount']) }}</h3>
                    <p>@lang('Total Cancel Amount')</p>
                </div>
            </div>
        </div>
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                <i class="las la-users overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="las la-sitemap"></i>
                </div>
                <div class="widget-two__content">
                    <h5 class="text-white">@lang('Categories')</h5>
                    <p class="text-white">{{ $total['categories'] }}</p>
                </div>
                <a href="{{ route('admin.category.index') }}" class="widget-two__btn">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                <i class="las la-users overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="las la-bullhorn"></i>
                </div>
                <div class="widget-two__content">
                    <h5 class="text-white">@lang('Coupons')</h5>
                    <p class="text-white">{{ $total['coupons'] }}</p>
                </div>
                <a href="{{ route('admin.coupon.index') }}" class="widget-two__btn">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--14">
                <i class="las la-users overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="las la-money-bill"></i>
                </div>
                <div class="widget-two__content">
                    <h5 class="text-white">@lang('Pending Payments')</h5>
                    <p class="text-white">{{ $total['pending_payments'] }}</p>
                </div>
                <a href="{{ route('admin.deposit.pending') }}" class="widget-two__btn">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two style--two box--shadow2 b-radius--5 bg--6">
                <i class="las la-users overlay-icon text--white"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="las la-ticket-alt"></i>
                </div>
                <div class="widget-two__content">
                    <h5 class="text-white">@lang('Pending Tickets')</h5>
                    <p class="text-white">{{ $total['pending_ticket'] }}</p>
                </div>
                <a href="{{ route('admin.ticket.pending') }}" class="widget-two__btn">@lang('View All')</a>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-2 col-lg-4 col-sm-6">
            <div class="widget-six bg--white rounded-2 box--shadow2 p-3">
                <div class="widget-six__top">
                    <i class="las la-list bg--1 text--white b-radius--5"></i>
                    <p>@lang('Total Orders')</p>
                </div>
                <div class="widget-six__bottom mt-3">
                    <h4 class="widget-six__number">{{ $order['total_orders'] }}</h4>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-2 col-lg-4 col-sm-6">
            <div class="widget-six bg--white rounded-2 box--shadow2 p-3">
                <div class="widget-six__top">
                    <i class="las la-spinner bg--warning text--white b-radius--5"></i>
                    <p>@lang('Pending Orders')</p>
                </div>
                <div class="widget-six__bottom mt-3">
                    <h4 class="widget-six__number">{{ $order['pending_orders'] }}</h4>
                    <a href="{{ route('admin.orders.pending') }}" class="widget-six__btn"><span class="text--small">@lang('View All')</span><i class="las la-arrow-right"></i></a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-2 col-lg-4 col-sm-6">
            <div class="widget-six bg--white rounded-2 box--shadow2 p-3">
                <div class="widget-six__top">
                    <i class="las la-truck bg--success text--white b-radius--5"></i>
                    <p>@lang('Processing Orders')</p>
                </div>
                <div class="widget-six__bottom mt-3">
                    <h4 class="widget-six__number">{{ $order['processing_orders'] }}</h4>
                    <a href="{{ route('admin.orders.processing') }}" class="widget-six__btn"><span class="text--small">@lang('View All')</span><i class="las la-arrow-right"></i></a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-2 col-lg-4 col-sm-6">
            <div class="widget-six bg--white rounded-2 box--shadow2 p-3">
                <div class="widget-six__top">
                    <i class="las la-home bg--primary text--white b-radius--5"></i>
                    <p>@lang('Delivered Orders')</p>
                </div>
                <div class="widget-six__bottom mt-3">
                    <h4 class="widget-six__number">{{ $order['delivered_orders'] }}</h4>
                    <a href="{{ route('admin.orders.delivered') }}" class="widget-six__btn"><span class="text--small">@lang('View All')</span><i class="las la-arrow-right"></i></a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-2 col-lg-4 col-sm-6">
            <div class="widget-six bg--white rounded-2 box--shadow2 p-3">
                <div class="widget-six__top">
                    <i class="las la-times-circle bg--danger text--white b-radius--5"></i>
                    <p>@lang('Cancelled Orders')</p>
                </div>
                <div class="widget-six__bottom mt-3">
                    <h4 class="widget-six__number">{{ $order['cancelled_orders'] }}</h4>
                    <a href="{{ route('admin.orders.cancelled') }}" class="widget-six__btn"><span class="text--small">@lang('View All')</span><i class="las la-arrow-right"></i></a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-2 col-lg-4 col-sm-6">
            <div class="widget-six bg--white rounded-2 box--shadow2 p-3">
                <div class="widget-six__top">
                    <i class="las la-hand-holding-usd bg--info text--white b-radius--5"></i>
                    <p>@lang('COD Orders')</p>
                </div>
                <div class="widget-six__bottom mt-3">
                    <h4 class="widget-six__number">{{ $order['cod_orders'] }}</h4>
                    <a href="{{ route('admin.orders.all') }}" class="widget-six__btn"><span class="text--small">@lang('View All')</span><i class="las la-arrow-right"></i></a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Last 30 days Orders History')</h5>
                    <div id="deposit-line"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Last 30 days Sales History')</h5>
                    <div id="sales-line"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>

    <script>
        "use strict";

        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });

        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });

        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });


        var options = {
            chart: {
                height: 430,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: "Series 1",
                data: @json($delivered['per_day_amount']->flatten())
            }],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($delivered['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#sales-line"), options);

        chart.render();

        // apex-line chart
        var options = {
            chart: {
                height: 430,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            colors: ['#00E396', '#0090FF'],
            dataLabels: {
                enabled: false
            },
            series: [{
                name: "Series 1",
                data: @json($orders['per_day_amount']->flatten())
            }],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($orders['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#deposit-line"), options);

        chart.render();
    </script>
@endpush

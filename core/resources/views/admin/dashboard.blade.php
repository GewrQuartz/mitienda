@extends('admin.layouts.app')

@section('panel')
    @if(@json_decode($general->sys_version)->version > systemDetails()['version'])
    <div class="row">
        <div class="col-md-12">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">
                    <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-right">@lang('Version') {{json_decode($general->sys_version)->version}}</button> </h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                    <p><pre  class="f-size--24">{{json_decode($general->sys_version)->details}}</pre></p>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(@json_decode($general->sys_version)->message)
    <div class="row">
        @foreach(json_decode($general->sys_version)->message as $msg)
        <div class="col-md-12">
            <div class="alert border border--primary" role="alert">
                <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                <p class="alert__message">@php echo $msg; @endphp</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="row mb-none-30">
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="widget bb--3 border--dark b-radius--10 bg--white p-4 box--shadow2 has--link">
                <div class="widget__icon b-radius--rounded bg--dark"><i class="las la-cart-arrow-down"></i></div>
                <div class="widget__content">
                    <p class="text-uppercase text-muted">@lang('All Order')</p>

                    <h1 class="text--dark font-weight-bold">
                        {{ $widget['all_orders'] }}
                    </h1>
                    <p class="mt-10 text-right">
                        <a class="btn btn-sm btn--dark" href="{{route('admin.order.index')}}">@lang('View All')
                        </a>
                    </p>
                </div>
            </div><!-- widget end -->
        </div>

        <div class="col-xl-4 col-md-6 mb-30">
            <div class="widget bb--3 border--teal b-radius--10 bg--white p-4 box--shadow2 has--link">
                <div class="widget__icon b-radius--rounded bg--teal">
                    <i class="las la-shopping-cart"></i>
                </div>
                <div class="widget__content">
                    <p class="text-uppercase text-muted">@lang('Total Sale')</p>

                    <h1 class="text--teal font-weight-bold">
                        {{$general->cur_sym}}{{ getAmount($payment['total_deposit_amount'], 2) }}
                    </h1>
                    <p class="mt-10 text-right">
                        <a class="btn btn-sm bg--teal text-white" href="{{ route('admin.deposit.list') }}">@lang('View All')
                        </a>
                    </p>
                </div>
            </div><!-- widget end -->
        </div>

        <div class="col-xl-4 col-md-6 mb-30">
            <div class="widget bb--3 border--light-blue b-radius--10 bg--white p-4 box--shadow2 has--link">
                <div class="widget__icon b-radius--rounded bg--light-blue">
                    <i class="las la-tshirt"></i>
                </div>
                <div class="widget__content">
                    <p class="text-uppercase text-muted">@lang('Total Product')</p>
                    <h1 class="text--light-blue font-weight-bold">
                        {{ $widget['total_product'] }}
                    </h1>
                    <p class="mt-10 text-right">
                        <a class="btn btn-sm bg--light-blue text-white" href="{{ route('admin.products.all') }}">@lang('View All')
                        </a>
                    </p>
                </div>
            </div><!-- widget end -->
        </div>

        <div class="col-xl-4 col-md-6 mb-30">
            <div class="widget bb--3 border--cyan b-radius--10 bg--white p-4 box--shadow2 has--link">
                <div class="widget__icon b-radius--rounded bg--cyan">
                    <i class="las la-users"></i>
                </div>

                <div class="widget__content">
                    <p class="text-uppercase text-muted">@lang('Total Customer')</p>
                    <h1 class="text--cyan font-weight-bold">{{ $widget['total_users'] }}</h1>

                    <p class="mt-10 text-right">
                        <a class="btn btn-sm bg--cyan text--white" href="{{route('admin.users.all')}}">
                            @lang('View All')
                        </a>
                    </p>
                </div>
            </div><!-- widget-two end -->
        </div>


        <div class="col-xl-4 col-md-6 mb-30">
            <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2 has--link">
                <div class="widget__icon b-radius--rounded bg--success">
                    <i class="las la-user-check"></i>
                </div>
                <div class="widget__content">
                    <p class="text-uppercase text-muted">@lang('Active Customers')</p>
                    <h1 class="text--success font-weight-bold">
                        {{$widget['verified_users']}}
                    </h1>
                    <p class="mt-10 text-right">
                        <a class="btn btn-sm btn--success" href="{{route('admin.users.active')}}">@lang('View All')
                        </a>
                    </p>
                </div>
            </div><!-- widget end -->
        </div>

        <div class="col-xl-4 col-md-6 mb-30">
            <div class="widget bb--3 border--deep-purple b-radius--10 bg--white p-4 box--shadow2 has--link">
                <div class="widget__icon b-radius--rounded bg--deep-purple">
                    <i class="las la-thumbs-up"></i>
                </div>
                <div class="widget__content">
                    <p class="text-uppercase text-muted">@lang('Total Subscriber')</p>
                    <h1 class="text--deep-purple font-weight-bold">
                        {{$widget['total_subscribers']}}
                    </h1>
                    <p class="mt-10 text-right">
                        <a class="btn btn-sm bg--deep-purple text--white" href="{{route('admin.subscriber.index')}}">@lang('View All')
                        </a>
                    </p>
                </div>
            </div><!-- widget end -->
        </div>


        <div class="col-xl-4 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="icon-7 overlay-icon text text--11"></i>
              <div class="widget-two__icon b-radius--5 bg--11">
                <i class="las la-money-bill"></i>
              </div>
              <div class="widget-two__content">
                <h2>{{$general->cur_sym}}{{ getAmount($widget['last_seven_days'], 2) }}</h2>
                <p>@lang('Sale Amount In Last 7 Days')</p>
              </div>
            </div><!-- widget-two end -->
        </div>

        <div class="col-xl-4 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="icon-15 overlay-icon text text--dark"></i>
              <div class="widget-two__icon b-radius--5 bg--15">
                <i class="las la-money-bill"></i>
              </div>
              <div class="widget-two__content">
                <h2>{{$general->cur_sym}}{{ getAmount($widget['last_fifteen_days'], 2) }}</h2>
                <p>@lang('Sale Amount In Last 15 Days')</p>
              </div>
            </div><!-- widget-two end -->
        </div>

        <div class="col-xl-4 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="icon-30 overlay-icon text text--danger"></i>
              <div class="widget-two__icon b-radius--5 bg--5">
                <i class="las la-money-bill"></i>
              </div>
              <div class="widget-two__content">
                <h2>{{$general->cur_sym}}{{ getAmount($widget['last_thirty_days'], 2) }}</h2>
                <p>@lang('Sale Amount In Last 30 Days')</p>
              </div>
            </div><!-- widget-two end -->
        </div>

    </div><!-- row end-->

    <div class="row mt-50 mb-none-30">
        <div class="col-xl-6 col-lg-12 mb-30">
            <div class="card min-height-500">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Sales Report')</h5>
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 mb-30">
            <div class="card min-height-500">
                <div class="card-body">
                    <h5 class="card-title">@lang('Top Selling Products')</h5>
                    @foreach ($widget['top_selling_products'] as $item)
                        @php
                            if($item->offer && $item->offer->activeOffer){
                                $discount = calculateDiscount($item->offer->activeOffer->amount, $item->offer->activeOffer->discount_type, $item->base_price);
                            }else $discount = 0;
                        @endphp

                        <div class="d-flex flex-wrap single-product mt-30">
                            <a href="{{ route('product.details', [$item->id, slug($item->name)]) }}" data-toggle="tooltip" data-placement="bottom" title="@lang('View As Customer')" class="col-md-2 text-center"><img src="{{ getImage(imagePath()['product']['path']. '/thumb_'. @$item->main_image, imagePath()['product']['size']) }}" alt="image"></a>

                            <div class="col-md-10 mt-md-0 mt-3">
                                <a href="{{ route('admin.products.edit', [$item->id, slug($item->name)]) }}" data-toggle="tooltip" data-placement="top" title="@lang('Edit')" class="text--blue font-weight-bold d-inline-block mb-2">{{ __($item->name) }}</a>
                                <p class="float-right">{{ $item->total }} @lang('sales')</p>
                                <p>{{ __(shortDescription($item->summary, 100)) }}</p>
                                <p class="font-weight-bold">

                                    @if($discount > 0)
                                        <del>{{ $general->cur_sym }}{{ getAmount($item->base_price, 2) }}</del>
                                        <span class="ml-2">{{ $general->cur_sym }}{{ getAmount($item->base_price - $discount, 2) }}</span>
                                    @else
                                        <span class="ml-2">{{ $general->cur_sym }}{{ getAmount($item->base_price, 2) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div><!-- media end-->
                    @endforeach
                </div>
            </div>
        </div>
    </div><!-- row end -->


    <div class="row mb-none-30 mt-5">
        <div class="col-xl-6 col-lg-12 mb-30">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('Latest Customers')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Username')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Order')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($latestUser as $user)
                                <tr>
                                    <td data-label="@lang('Customer')">
                                        <div class="user">
                                            <div class="thumb">
                                                <a href="{{ getAvatar('assets/images/user/profile/'. $user->image)}}" class="image-popup">
                                                    <img src="{{ getAvatar('assets/images/user/profile/'. $user->image)}}" alt="@lang('image')">
                                                </a>
                                            </div>
                                            <span class="name">{{$user->fullname}}</span>
                                        </div>
                                    </td>

                                    <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $user->id) }}">{{ $user->username }}</a></td>
                                    <td data-label="@lang('Email')">{{ $user->email }}</td>
                                    <td data-label="@lang('Order')">{{ $user->orders->count() }}</td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn" data-toggle="tooltip" data-original-title="@lang('Details')">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Customer Not Found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>

        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('Latest Orders')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Customer')</th>
                                    <th scope="col">@lang('Order Id')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Shipping Charge')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recent_orders as $order)
                                <tr>
                                    <td data-label="@lang('Customer')">
                                        <div class="user">
                                            <div class="thumb">
                                                <a href="{{ getAvatar('assets/images/user/profile/'. $order->user->image)}}" class="image-popup">
                                                    <img src="{{ getAvatar('assets/images/user/profile/'. $order->user->image)}}" alt="image">
                                                </a>
                                            </div>
                                            <span class="name">{{$order->user->fullname}}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Order Id')">{{$order->order_number}}</td>
                                    <td data-label="@lang('Amount')">{{$order->amount}}</td>
                                    <td data-label="@lang('Shipping Charge')">{{$order->shipping_charge}}</td>
                                    <td>
                                        <a href="{{route('admin.order.details', $order->id)}}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="Details">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('No Order Yet')</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!--card end-->


    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser')</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS')</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country')</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script src="{{asset('assets/admin/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/chart.js.2.8.0.js')}}"></script>
    <script>
        "use strict";
        (function($){
            $('.image-popup').magnificPopup({
                type: 'image'
            });
        })(jQuery)
        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Sale',
                data: @json($report['deposit_month_amount']->flatten())
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($report['months']->flatten()),
            },
            yaxis: {
                title: {
                    text: "{{$general->cur_sym}}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
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
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "{{$general->cur_sym}}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();

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

    </script>
@endpush

<div class="sidebar capsule--rounded bg_img overlay--dark" data-background="{{getImage('assets/admin/images/sidebar/2.jpg','400x800')}}"
     >
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo_2.png')}}" alt="@lang('image')"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">

                <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.users*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('Customers')</span>

                        @if($banned_users_count > 0 || $email_unverified_users_count > 0 || $sms_unverified_users_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.users*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.users.all')}} ">
                                <a href="{{route('admin.users.all')}}" class="nav-link">
                                    <i class="menu-icon las la-user-friends"></i>
                                    <span class="menu-title">@lang('All Customer')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.active')}} ">
                                <a href="{{route('admin.users.active')}}" class="nav-link">
                                    <i class="menu-icon las la-user-check"></i>
                                    <span class="menu-title">@lang('Active Customers')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.users.banned')}} ">
                                <a href="{{route('admin.users.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-user-times"></i>
                                    <span class="menu-title">@lang('Banned Customers')</span>
                                    @if($banned_users_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{ $banned_users_count }}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item  {{menuActive('admin.users.emailUnverified')}}">
                                <a href="{{route('admin.users.emailUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-user-alt-slash"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if($email_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$email_unverified_users_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.smsUnverified')}}">
                                <a href="{{route('admin.users.smsUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-user-alt-slash"></i>
                                    <span class="menu-title">@lang('SMS Unverified')</span>
                                    @if($sms_unverified_users_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$sms_unverified_users_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.login.history')}}">
                                <a href="{{route('admin.users.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-history"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.email.all')}}">
                                <a href="{{route('admin.users.email.all')}}" class="nav-link">
                                    <i class="menu-icon las la-envelope"></i>
                                    <span class="menu-title">@lang('Send Email')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive(['admin.product*', 'admin.category.*', 'admin.subcategory.*', 'admin.attributes*', 'admin.brand.*'], 3) }}">
                        <i class="la la-product-hunt menu-icon"></i>
                        <span class="menu-title">@lang('Product')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.product*', 'admin.category.*', 'admin.subcategory.*', 'admin.attributes*', 'admin.brand.*'], 2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.category.*') }}">
                                <a class="nav-link" href="{{ route('admin.category.all') }}">
                                    <i class="las la-align-left menu-icon"></i>
                                    <span class="menu-title">@lang('Categories')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.brand.*') }}">
                                <a class="nav-link" href="{{ route('admin.brand.all') }}">
                                    <i class="la la-tags menu-icon"></i>
                                    <span class="menu-title">@lang('Brands')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.attributes*') }}">
                                <a class="nav-link" href="{{ route('admin.attributes') }}">
                                    <i class="la la-palette menu-icon"></i>
                                    <span class="menu-title">@lang('Attribute Types')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.products.*') }}">
                                <a class="nav-link" href="{{ route('admin.products.all') }}">
                                    <i class="menu-icon las la-tshirt"></i>
                                    <span class="menu-title">@lang('Products')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.product.review*') }}">
                                <a class="nav-link" href="{{ route('admin.product.reviews') }}">
                                    <i class="menu-icon las la-star"></i>
                                    <span class="menu-title">@lang('Product Reviews')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive(['admin.coupon*', 'admin.offer.*', 'admin.subscriber.*' ], 3) }}">
                        <i class="la la-bullhorn menu-icon"></i>
                        <span class="menu-title">@lang('Promotion')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.coupon*', 'admin.offer.*', 'admin.subscriber.*'], 2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.coupon*') }}">
                                <a class="nav-link" href="{{ route('admin.coupon.index') }}">
                                    <i class="menu-icon lab la-contao"></i>
                                    <span class="menu-title">@lang('Coupons')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.offer*') }}">
                                <a class="nav-link" href="{{ route('admin.offer.index') }}">
                                    <i class="menu-icon la la-fire-alt"></i>
                                    <span class="menu-title">@lang('Offers')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item  {{menuActive('admin.subscriber.index')}}">
                                <a href="{{route('admin.subscriber.index')}}" class="nav-link"
                                data-default-url="{{ route('admin.subscriber.index') }}">
                                    <i class="menu-icon la la-thumbs-up"></i>
                                    <span class="menu-title">@lang('Subscribers') </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive(['admin.deposit.pending', 'admin.deposit.approved', 'admin.deposit.successful', 'admin.deposit.rejected', 'admin.deposit.list*', 'admin.deposit.search'],3)}}">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title">@lang('Payments')</span>
                        @if(0 < $pending_deposits_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.deposit.pending', 'admin.deposit.approved', 'admin.deposit.successful', 'admin.deposit.rejected', 'admin.deposit.list*', 'admin.deposit.search'],2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.list')}} ">
                                <a href="{{route('admin.deposit.list')}}" class="nav-link">
                                    <i class="menu-icon las la-list-ul"></i>
                                    <span class="menu-title">@lang('All Payments')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.pending')}} ">
                                <a href="{{route('admin.deposit.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-pause-circle"></i>
                                    <span class="menu-title">@lang('Pending Payments')</span>
                                    @if($pending_deposits_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_deposits_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.approved')}} ">
                                <a href="{{route('admin.deposit.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-check-circle"></i>
                                    <span class="menu-title">@lang('Approved Payments')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.successful')}} ">
                                <a href="{{route('admin.deposit.successful')}}" class="nav-link">
                                    <i class="menu-icon las la-check-double"></i>
                                    <span class="menu-title">@lang('Successful Payments')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.rejected')}} ">
                                <a href="{{route('admin.deposit.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-times-circle"></i>
                                    <span class="menu-title">@lang('Rejected Payments')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.order*',3)}}">
                        <i class="las la-money-bill menu-icon"></i>
                        <span class="menu-title">@lang('Orders')</span>
                        @if($pending_orders_count > 0 || $processing_orders_count || $dispatched_orders_count > 0)
                        <span class="menu-badge pill bg--primary ml-auto">
                            <i class="las la-bell"></i>
                        </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.order*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.order.index') }}">
                                <a class="nav-link" href="{{ route('admin.order.index') }}">
                                    <i class="menu-icon las la-list-ol"></i>
                                    <span class="menu-title">@lang('All Orders')</span>

                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.order.to_deliver')}}">
                                <a class="nav-link" href="{{ route('admin.order.to_deliver') }}">
                                    <i class="menu-icon las la-pause-circle"></i>
                                    <span class="menu-title">@lang('Pending Orders')</span>
                                    @if($pending_orders_count > 0)
                                    <span class="badge bg--primary badge-pill ml-2"><i class="fas fa-exclamation"></i></span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.order.on_processing') }}">
                                <a class="nav-link" href="{{ route('admin.order.on_processing') }}">
                                    <i class="menu-icon las la-spinner"></i>
                                    <span class="menu-title">@lang('Processing Orders')</span>
                                    @if($processing_orders_count > 0)
                                    <span class="badge bg--primary badge-pill ml-2"><i class="fas fa-exclamation"></i></span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.order.dispatched') }}">
                                <a class="nav-link" href="{{ route('admin.order.dispatched') }}">
                                    <i class="menu-icon las la-shopping-basket"></i>

                                    <span class="menu-title">@lang('Dispatched Orders')</span>

                                    @if($dispatched_orders_count > 0)
                                    <span class="badge bg--primary badge-pill ml-2"><i class="fas fa-exclamation"></i></span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.order.delivered') }}">
                                <a class="nav-link" href="{{ route('admin.order.delivered') }}">
                                    <i class="menu-icon las la-check-circle"></i>
                                    <span class="menu-title">@lang('Delivered Orders') </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.order.canceled') }}">
                                <a class="nav-link" href="{{ route('admin.order.canceled') }}">
                                    <i class="menu-icon las la-times-circle"></i>
                                    <span class="menu-title">@lang('Canceled Orders')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.order.cod') }}">
                                <a class="nav-link" href="{{ route('admin.order.cod') }}">
                                    <i class="menu-icon las la-hand-holding-usd"></i>
                                    <span class="menu-title"><abbr data-toggle="tooltip" title="@lang('Cash On Delivery')">{{ @$deposit->gateway->name??trans('COD') }}</abbr> @lang('Orders')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.ticket*',3)}}">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                        @if(0 < $pending_ticket_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.ticket*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.ticket')}} ">
                                <a href="{{route('admin.ticket')}}" class="nav-link">
                                    <i class="menu-icon las la-list"></i>
                                    <span class="menu-title">@lang('All Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.pending')}} ">
                                <a href="{{route('admin.ticket.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-pause-circle"></i>
                                    <span class="menu-title">@lang('Pending Ticket')</span>
                                    @if($pending_ticket_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$pending_ticket_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.closed')}} ">
                                <a href="{{route('admin.ticket.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-times-circle"></i>
                                    <span class="menu-title">@lang('Closed Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.ticket.answered')}} ">
                                <a href="{{route('admin.ticket.answered')}}" class="nav-link">
                                    <i class="menu-icon las la-reply"></i>
                                    <span class="menu-title">@lang('Answered Ticket')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.report*',3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.report*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive(['admin.report.transaction*'])}}">
                                <a href="{{route('admin.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-money-check"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.report.order*') }}">
                                <a class="nav-link" href="{{ route('admin.report.order') }}">
                                    <i class="menu-icon las la-cart-arrow-down"></i>
                                    <span class="menu-title">@lang('Order Log')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header">@lang('Store Front')</li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.frontend.sections*',3)}}">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('Manage Contents')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.frontend.sections*',2)}} ">
                        <ul>
                            @php
                            $lastSegment =  collect(request()->segments())->last();
                            @endphp
                            @foreach(getPageSections(true) as $k => $secs)
                                @if($secs['builder'])
                                    <li class="sidebar-menu-item  @if($lastSegment == $k) active @endif ">
                                        <a href="{{ route('admin.frontend.sections',$k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{__($secs['name'])}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.seo')}}">
                    <a href="{{route('admin.seo')}}" class="nav-link">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title">@lang('SEO')</span>
                    </a>
                </li>

                <li class="sidebar__menu-header">@lang('System')</li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive(['admin.deposit.manual.*', 'admin.deposit.gateway.*'],3)}}">
                        <i class="menu-icon la la-paypal"></i>
                        <span class="menu-title">@lang('Gateways')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.deposit.manual.*', 'admin.deposit.gateway.*'],2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.gateway.*')}} ">
                                <a href="{{route('admin.deposit.gateway.index')}}" class="nav-link">
                                    <i class="menu-icon lab la-amazon-pay"></i>
                                    <span class="menu-title">@lang('Automatic Gateways')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.deposit.manual.*')}} ">
                                <a href="{{route('admin.deposit.manual.index')}}" class="nav-link">
                                    <i class="menu-icon las la-money-bill"></i>
                                    <span class="menu-title">@lang('Manual Gateways')</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.shipping-methods*') }}">
                    <a href="{{ route('admin.shipping-methods.all') }}" class="nav-link">
                        <i class="fas fa-shipping-fast menu-icon"></i>
                        <span class="menu-title">@lang('Shipping Methods')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive(['admin.setting*', 'admin.language*', 'admin.plugin*'],3)}}">
                        <i class="menu-icon la la-tools"></i>
                        <span class="menu-title">@lang('Settings')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['admin.setting*', 'admin.language*', 'admin.plugin*'],2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.setting.index')}}">
                                <a href="{{route('admin.setting.index')}}" class="nav-link">
                                    <i class="menu-icon las la-life-ring"></i>
                                    <span class="menu-title">@lang('Genreal')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.setting.logo-icon')}}">
                                <a href="{{route('admin.setting.logo-icon')}}" class="nav-link">
                                    <i class="menu-icon las la-images"></i>
                                    <span class="menu-title">@lang('Logos & Favicon')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item  {{menuActive(['admin.language-manage','admin.language-key'])}}">
                                <a href="{{route('admin.language-manage')}}" class="nav-link"
                                   data-default-url="{{ route('admin.language-manage') }}">
                                    <i class="menu-icon las la-language"></i>
                                    <span class="menu-title">@lang('Language') </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.plugin.index')}}">
                                <a href="{{route('admin.plugin.index')}}" class="nav-link">
                                    <i class="menu-icon las la-cogs"></i>
                                    <span class="menu-title">@lang('Plugins')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar__menu-header">@lang('Notification')</li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.email_template*',3)}}">
                        <i class="menu-icon la la-envelope-o"></i>
                        <span class="menu-title">@lang('Email')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.email-template*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('admin.email_template.global')}} ">
                                <a href="{{route('admin.email_template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-envelope-open-text"></i>
                                    <span class="menu-title">@lang('Global Template')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive(['admin.email-template.index','admin.email-template.edit'])}} ">
                                <a href="{{ route('admin.email-template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-envelope-open"></i>
                                    <span class="menu-title">@lang('Email Templates')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.email-template.setting')}} ">
                                <a href="{{route('admin.email-template.setting')}}" class="nav-link">
                                    <i class="menu-icon las la-at"></i>
                                    <span class="menu-title">@lang('Email Configure')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.sms-template*',3)}}">
                        <i class="menu-icon la la-mobile"></i>
                        <span class="menu-title">@lang('SMS')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.sms-template*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.sms-template.global')}} ">
                                <a href="{{route('admin.sms-template.global')}}" class="nav-link">
                                    <i class="menu-icon las la-database"></i>
                                    <span class="menu-title">@lang('API Setting')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive(['admin.sms-template.index','admin.sms-template.edit'])}} ">
                                <a href="{{ route('admin.sms-template.index') }}" class="nav-link">
                                    <i class="menu-icon las la-sms"></i>
                                    <span class="menu-title">@lang('SMS Templates')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar__menu-header">@lang('Others')</li>
                <li class="sidebar-menu-item {{menuActive('clear-cache')}} ">
                    <a href="{{ route('clear-cache') }}" class="nav-link">
                        <i class="menu-icon las la-history"></i>
                        <span class="menu-title">@lang('Clear Cache')</span>
                    </a>
                </li>

              <!--  <li class="sidebar-menu-item mt-2">
                    <div class="nav-link d-flex justify-content-center">
                        <span>
                            <span class="text--primary font-weight-bold">{{systemDetails()['name']}}</span>
                            <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
                        </span>
                    </div>
                </li>
                -->
            </ul>


        </div>
    </div>
</div>
<!-- sidebar end -->

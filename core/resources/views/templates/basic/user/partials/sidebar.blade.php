<li>
    <a href="{{ route('user.home') }}" class="{{ menuActive('user.home') }}"> <i class="las la-home"></i>@lang('Dashboard')</a>
</li>
<li>
    <a href="{{ route('user.profile-setting') }}" class="{{ menuActive('user.profile-setting') }}"><i class="las la-user-alt"></i>@lang('Profile')</a>
</li>

<li>
    <a href="{{ route('user.deposit.history') }}" class="{{ menuActive('user.deposit.history') }}"><i class="las la-money-bill-wave"></i>@lang('Payment Log')</a>
</li>

<li>
    <a href="{{route('user.orders', 'all')}}" class="{{ menuActive('user.orders') }}"><i class="las la-list"></i>@lang('Order Log')</a>
</li>

<li>
    <a href="{{route('user.product.to_review')}}" class="{{ menuActive('user.product.to_review') }}"><i class="la la-star"></i> @lang('Review Products')</a>
</li>

<li>
    <a href="{{route('ticket')}}" class="{{ menuActive('ticket') }}"><i class="la la-ticket"></i> @lang('Support Tickets')</a>
</li>

<li>
    <a href="{{ route('user.logout') }}"><i class="la la-sign-out"></i>@lang('Sign Out')</a>
</li>

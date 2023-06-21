@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard-section padding-bottom padding-top">
    <div class="container">
        <div class="row">
            @foreach($gatewayCurrency as $data)

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs mb-5">
                <div class="card">
                    <div class="card-header p-0">
                        <img class="card-img-top" src="{{ $data->methodImage() }}" alt="@lang('gateway-image')">
                    </div>
                    <div class="card-body">
                        <form action="{{route('user.deposit.insert')}} " method="POST">
                            @csrf
                            <input type="hidden" name="currency" class="edit-currency" value="{{$data->currency}}">
                            <input type="hidden" name="method_code" class="edit-method-code" value="{{$data->method_code}}">
                            <button type="submit" class="cmn-btn btn-block">@lang('Pay Now')</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
    <li><a href="{{route('products')}}">@lang('Products')</a></li>
    <li><a href="{{route('shopping-cart')}}">@lang('Cart')</a></li>
    <li><a href="{{route('user.checkout')}}">@lang('Checkout')</a></li>
@endpush




@extends($activeTemplate.'layouts.master')

@section('content')
<div class="checkout-section padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <img src="{{ $deposit->gateway_currency()->methodImage() }}" class="card-img-top w-25" @lang('gateway-image')">
                        <h3 class="align-self-center cl-1">
                            @lang('Payment Confirm')
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{$data->url}}" method="{{$data->method}}">

                            <p class="mt-3 mb-4 text-center">@lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</p>

                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >

                            </script>

                            <input type="hidden" custom="{{$data->custom}}" name="hidden">

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
        'use strict';
        (function($){
            $('input[type="submit"]').addClass("ml-4 mt-4 btn-custom2 text-center btn-lg");

        })(jQuery)

    </script>
@endpush

@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
    <li><a href="{{route('products')}}">@lang('Products')</a></li>
    <li><a href="{{route('shopping-cart')}}">@lang('Cart')</a></li>
    <li><a href="{{route('user.checkout')}}">@lang('Checkout')</a></li>
    <li><a href="{{route('user.deposit')}}">@lang('Payment')</a></li>
    <li><a href="{{route('user.deposit.preview')}}">@lang('Payment Preview')</a></li>
@endpush

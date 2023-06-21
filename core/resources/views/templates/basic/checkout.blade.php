@extends(activeTemplate() .'layouts.master')

@section('content')
    <!-- Checkout Section Starts Here -->
    <div class="checkout-section padding-bottom padding-top">
        <div class="container">
            <div class="checkout-area section-bg">
                <div class="row flex-wrap-reverse">
                    <div class="col-md-6 col-lg-7 col-xl-8">
                        <div class="checkout-wrapper">
                            <h4 class="title text-center">@lang('Shipping Address')</h4>
                            <ul class="nav-tabs nav justify-content-center">
                                <li>
                                    <a href="#self" data-toggle="tab" class="active">@lang('For Yourself')</a>
                                </li>
                                <li>
                                    <a href="#guest" data-toggle="tab">@lang('Order As Gift')</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show fade active" id="self">
                                    <form action="{{route('user.checkout-to-payment', 1)}}" method="post" class="billing-form mb--20">
                                        @csrf

                                        <div class="row">


                                            <div class="col-lg-12 mb-20">
                                                <label for="shipping-method" class="billing-label">@lang('Shipping Method')</label>
                                                <div class="billing-select">
                                                    <select name="shipping_method" required>
                                                        <option value="">@lang('Select One')</option>
                                                        @foreach ($shipping_methods as $sm)
                                                            <option data-shipping="{{$sm->description}}" data-charge="{{$sm->charge}}" value="{{$sm->id}}">{{$sm->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-20">
                                                <label for="fname" class="billing-label">@lang('First Name')</label>
                                                <input class="form-control custom--style" id="fname" type="text" name="firstname" value="{{auth()->user()->firstname?? old('firstname')}}" required>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="lname" class="billing-label">@lang('Last Name')</label>
                                                <input class="form-control custom--style" id="lname" name="lastname" type="text" value="{{auth()->user()->lastname?? old('lastname')}}" required>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="phone" class="billing-label">@lang('Mobile')</label>
                                                <input class="form-control custom--style" id="phone" name="mobile" type="text" value="{{auth()->user()->mobile?? old('mobile')}}" required>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="email" class="billing-label">@lang('Email')</label>
                                                <input class="form-control custom--style" id="email" name="email" type="text" value="{{auth()->user()->email?? old('mobile')}}" required>
                                            </div>

                                            <div class="col-lg-6 mb-20">
                                                <label for="country" class="billing-label">@lang('Country')</label>
                                                <div class="billing-select">
                                                    <select name="country" id="country" class="select-bar" required>
                                                        @include('partials.country')
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-20">
                                                <label for="city" class="billing-label">@lang('City')</label>
                                                <input class="form-control custom--style" id="city" name="city" type="text" value="{{auth()->user()->address->city?? old('city')}}" required>
                                            </div>

                                            <div class="col-md-6 mb-20">
                                                <label for="state" class="billing-label">@lang('State')</label>
                                                <input class="form-control custom--style" id="state" name="state" type="text" value="{{auth()->user()->address->state?? old('state')}}" required>
                                            </div>

                                            <div class="col-md-6 mb-20">
                                                <label for="zip" class="billing-label">@lang('Zip/Post Code')</label>
                                                <input class="form-control custom--style" id="zip" name="zip" type="text" value="{{auth()->user()->address->zip?? old('zip')}}" required>
                                            </div>

                                            <div class="col-md-12 mb-20">
                                                <label for="address" class="billing-label">@lang('Address')</label>
                                                <textarea class="form-control custom--style" name="address" id="address" required>{{auth()->user()->address->address??old('address')}}</textarea>
                                            </div>
                                        </div>


                                        <div class="row justify-content-end">
                                            @if($general->cod)
                                            <div class="col-lg-6 mb-20">
                                                <button type="submit" name="cash_on_delivery" value="1" class="bill-button">@lang('Cash On Delivery')</abbr></button>
                                            </div>
                                            @endif
                                            <div class="col-lg-6 mb-20">
                                                <button type="" name="payment" value="1" class="bill-button">@lang('Continue to Payment')</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade" id="guest">
                                    <form action="{{route('user.checkout-to-payment', 2)}}" method="post" class="guest-form mb--20">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-12 mb-20">
                                                <label for="shipping-method-2" class="billing-label">@lang('Shipping Method')</label>
                                                <div class="billing-select">
                                                    <select name="shipping_method" id="shipping-method-2" required>
                                                        <option value="">@lang('Select One')</option>
                                                        @foreach ($shipping_methods as $sm)
                                                            <option data-shipping="{{$sm->description}}" data-charge="{{$sm->charge}}" value="{{$sm->id}}">{{$sm->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="firstname" class="billing-label">@lang('First Name')</label>
                                                <input class="form-control custom--style" id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" required>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="lastname" class="billing-label">@lang('Last Name')</label>
                                                <input class="form-control custom--style" id="lastname" name="lastname" type="text" value="{{ old('lastname')}}" required>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="mobile" class="billing-label">@lang('Mobile')</label>
                                                <input class="form-control custom--style" id="mobile" name="mobile" type="text" value="{{ old('mobile')}}" required>
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label for="e-mail" class="billing-label">@lang('Email')</label>
                                                <input class="form-control custom--style" id="e-mail" name="email" type="text" required>
                                            </div>

                                            <div class="col-lg-6 mb-20">
                                                <label for="country-2" class="billing-label">@lang('Country')</label>
                                                <div class="billing-select">
                                                    <select name="country" id="country-2" class="select-bar" required>
                                                        @include('partials.country')
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-20">
                                                <label for="city-2" class="billing-label">@lang('City')</label>
                                                <input class="form-control custom--style" id="city-2" name="city" type="text" value="{{ old('city') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-20">
                                                <label for="state-2" class="billing-label">@lang('State')</label>
                                                <input class="form-control custom--style" id="state-2" name="state" type="text" value="{{ old('state') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-20">
                                                <label for="zip-2" class="billing-label">@lang('Zip/Post Code')</label>
                                                <input class="form-control custom--style" id="zip-2" name="zip" type="text" value="{{ old('zip') }}" required>
                                            </div>

                                            <div class="col-md-12 mb-20">
                                                <label for="address-2" class="billing-label">@lang('Address')</label>
                                                <textarea class="form-control custom--style" id="address-2" name="address" required>{{ old('address')}}</textarea>
                                            </div>
                                        </div>

                                        <div class="row justify-content-end">
                                            @if($general->cod)
                                                <div class="col-lg-6 mb-20">
                                                    <button type="submit" name="cash_on_delivery" value="1" class="bill-button">@lang('Cash On Delivery')</abbr></button>
                                                </div>
                                            @endif
                                            <div class="col-lg-6 mb-20">
                                                <button type="" name="payment" value="1" class="bill-button">@lang('Continue to Payment')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 col-xl-4">
                        <div class="payment-details">
                            <h4 class="title text-center">@lang('Payment Details')</h4>
                            <ul>
                                <li>
                                    <span class="subtitle">@lang('Subtotal')</span>
                                    <span class="text-success" id="cartSubtotal">{{$general->cur_sym}}0</span>
                                </li>
                                @if(session()->has('coupon'))
                                    <li>
                                        <span class="subtitle">@lang('Coupon') ({{session('coupon')['code']}})</span>
                                        <span class="text-success" id="couponAmount">{{$general->cur_sym}}{{ getAmount(session('coupon')['amount'], 2)}}</span>
                                    </li>

                                    <li>
                                        <span class="subtitle">(<i class="la la-minus"></i>)</span>
                                        <span class="text-success" id="afterCouponAmount">{{$general->cur_sym}}0</span>
                                    </li>
                                @endif
                                <li>
                                    <span class="subtitle">@lang('Shipping Charge')</span>
                                    <span class="text-danger" id="shippingCharge">{{$general->cur_sym}}0</span>
                                </li>
                                <li class="border-0">
                                    <span class="subtitle bold">@lang('Total')</span>
                                    <span class="cl-title" id="cartTotal">{{$general->cur_sym}}0</span>
                                </li>
                            </ul>
                            <p id="shipping-details">

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Section Ends Here -->

@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            var sub_total = Number(sessionStorage.getItem('subtotal'));
            $('#cartSubtotal').text(`{{$general->cur_sym}}`+ parseFloat(sub_total).toFixed(2));

            var couponAmount = @if(session()->has('coupon')) {{session('coupon')['amount']}} @else 0 @endif ;

            var afterCouponAmount = (sub_total - couponAmount).toFixed(2);

            $('#afterCouponAmount').text(afterCouponAmount)

            $('#cartTotal').text(`{{$general->cur_sym}}`+ parseFloat(sub_total - couponAmount).toFixed(2));

            $('select[name=country]').val("{{isset(auth()->user()->address->country)?auth()->user()->address->country:''}}");

            $('select[name=shipping_method]').on('change', function(){
                var charge = parseFloat($('option:selected',this).data("charge"));
                var detail = $('option:selected',this).data('shipping');

                if(isNaN(charge)){
                    charge = 0;
                }
                if(detail){
                    $('#shipping-details').html(detail);
                }else{
                    $('#shipping-details').html('');
                }
                $('#shippingCharge').text(`{{$general->cur_sym}}` + parseFloat(charge).toFixed(2));
                $('#cartTotal').text(`{{$general->cur_sym}}` + (parseFloat(afterCouponAmount) + charge).toFixed(2));
            }).change();

        })(jQuery)
    </script>
@endpush

@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
    <li><a href="{{route('products')}}">@lang('Products')</a></li>
    <li><a href="{{route('shopping-cart')}}">@lang('Cart')</a></li>
@endpush


@push('meta-tags')
    @include('partials.seo')
@endpush

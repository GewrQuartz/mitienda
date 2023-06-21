@extends($activeTemplate.'layouts.master')

@section('content')
<div class="checkout-section padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card card-deposit">
                    <div class="card-header">
                        <h5 class="card-title align-self-center mt-2 cl-1">@lang('Stripe Payment')</h5>
                    </div>
                    <div class="card-body card-body-deposit">
                        <div class="card-wrapper"></div>
                        <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$data->track}}" name="track">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">@lang('CARD NAME')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg custom-input" name="name"
                                               placeholder="@lang('Card Name')" autocomplete="off" autofocus/>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text addon-bg"><i class="fa fa-font"></i></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="cardNumber">@lang('CARD NUMBER')</label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control form-control-lg custom-input"
                                               name="cardNumber" placeholder="@lang('Valid Card Number')" autocomplete="off"
                                               required autofocus/>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text addon-bg"><i
                                                    class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label for="cardExpiry">@lang('EXPIRATION DATE')</label>
                                    <input type="tel" class="form-control form-control-lg input-sz custom-input"
                                           name="cardExpiry" placeholder="@lang('MM / YYYY')" autocomplete="off" required/>
                                </div>
                                <div class="col-md-6 ">

                                    <label for="cardCVC">@lang('CVC CODE')</label>
                                    <input type="tel" class="form-control form-control-lg input-sz custom-input"
                                           name="cardCVC" placeholder="@lang('CVC')" autocomplete="off" required/>
                                </div>
                            </div>
                            <br>
                            <button class="cmn-btn btn-block" type="submit"> @lang('PAY NOW')
                            </button>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        "use strict";
        (function ($) {

            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });

        })(jQuery);
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

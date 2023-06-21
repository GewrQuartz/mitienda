@extends($activeTemplate.'layouts.master')
@section('content')
@php
    $register_content        = getContent('register_page.content', true);
@endphp
    <div class="account-section padding-bottom padding-top">

        <div class="contact-thumb rev-side d-none d-lg-block">
            <img src="{{ getImage('assets/images/frontend/register_page/'. @$register_content->data_values->image, '600x840') }}" alt="register-bg">
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-5">
                    <div class="section-header left-style">
                        <h3 class="title">{{ __($register_content->data_values->title) }}</h3>
                        <p>{{ __($register_content->data_values->description) }}</p>
                    </div>
                    <form action="{{ route('user.register') }}" method="POST" class="contact-form mb-30-none">
                        @csrf

                        <div class="contact-group">
                            <label for="firstname">@lang('First Name')</label>
                            <input id="firstname" type="text" name="firstname" value="{{ old('firstname	') }}" required>
                        </div>

                        <div class="contact-group">
                            <label for="lastname">@lang('Last Name')</label>
                            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname	') }}" required>
                        </div>

                        <div class="contact-group">
                            <label for="username">@lang('Username')</label>
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required>
                        </div>

                        <div class="contact-group country-code">
                            <label>@lang('Mobile')</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <select name="country_code">
                                            @include('partials.country_code')
                                        </select>
                                    </span>
                                </div>
                                <input type="text" name="mobile" class="form-control" placeholder="@lang('Your Phone Number')">
                            </div>
                        </div>

                        <div class="contact-group">
                            <label for="email">@lang('Country')</label>
                            <input type="text" name="country"  readonly>
                        </div>


                        <div class="contact-group">
                            <label for="email">@lang('Email')</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="contact-group">
                            <label for="password">@lang('Password')</label>

                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">

                        </div>

                        <div class="contact-group">
                            <label for="password-confirm">@lang('Confirm Password')</label>

                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                        </div>


                        @php $captcha =   getCustomCaptcha('register captcha') @endphp
                        @if($captcha)
                        <div class="contact-group">
                            <label for="password">@lang('Captcha')</label>
                            <input type="text" name="captcha" autocomplete="off" placeholder="@lang('Enter The Code Below')">

                            <div class="d-flex mt-4 justify-content-end w-100">
                                @php echo  getCustomCaptcha('register captcha') @endphp
                            </div>
                        </div>
                        @endif

                        <div class="contact-group">
                            <div class="w-100 ">
                                <div class="m--10 d-flex flex-wrap align-items-center justify-content-between">
                                    <span class="account-alt">@lang('Already have an account?') <a href="{{ route('user.login') }}">@lang('Login')</a></span>

                                    <button type="submit" id="recaptcha" class="custom-button d-sm-block">@lang('Sign Up')</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
<script>
    'use strict';

    (function($){
        @if($country_code)
        var t = $(`option[data-code={{ $country_code }}]`).attr('selected','');
        @endif

        var country = $('select[name=country_code] :selected').data('country');
        if(country){
            $('input[name=country]').val(country);
        }

        $('select[name=country_code]').on('change', function(){
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        });

    })(jQuery)

  </script>
@endpush

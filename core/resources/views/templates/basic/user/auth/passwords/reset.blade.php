@extends($activeTemplate.'layouts.master')


@section('content')
@php
    $content        = getContent('reset_password_page.content', true);
@endphp

<div class="account-section padding-bottom padding-top">
    <div class="contact-thumb d-none d-lg-block">
        <img src="{{ getImage('assets/images/frontend/reset_password_page/'. @$content->data_values->image, '600x840') }}" alt="@lang('login-bg')">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="section-header left-style">
                    <h3 class="title">{{ __($content->data_values->title) }}</h3>
                    <p>{{ __($content->data_values->description) }}</p>
                </div>

                    <form method="POST" action="{{ route('user.password.update') }}" class="contact-form mb-30-none">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">


                        <div class="contact-group">
                            <label for="password">@lang('Password')</label>
                            <input id="password" type="password" name="password" name="password" required autocomplete="new-password">
                        </div>

                        <div class="contact-group">
                            <label for="password-confirm">@lang('Confirm Password')</label>
                            <input id="password-confirm" type="password" n name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="contact-group">
                            <div class="m--10 d-flex flex-wrap align-items-center w-100 justify-content-between">
                                <span class="account-alt"><a href="{{ route('user.login') }}">@lang('Login')</a></span>
                                <button type="submit" class="custom-button m-0 ml-auto">@lang('Reset Password')</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@endsection

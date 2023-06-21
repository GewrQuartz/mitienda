@extends('templates.basic.layouts.master')

@section('content')

@php
    $content        = getContent('forgot_password_page.content', true);
@endphp

<div class="account-section padding-bottom padding-top">
    <div class="contact-thumb d-none d-lg-block">
        <img src="{{ getImage('assets/images/frontend/forgot_password_page/'. @$content->data_values->image, '600x840') }}" alt="@lang('login-bg')">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="section-header left-style">
                    <h3 class="title">{{ __($content->data_values->title) }}</h3>
                    <p>{{ __($content->data_values->description) }}</p>
                </div>

                    <form method="POST" action="{{ route('user.password.email') }}" class="contact-form mb-30-none">
                        @csrf

                        <div class="contact-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        </div>

                        <div class="contact-group">
                            <button type="submit" class="custom-button m-0 ml-auto">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection

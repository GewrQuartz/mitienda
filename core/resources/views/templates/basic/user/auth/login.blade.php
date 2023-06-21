@extends($activeTemplate.'layouts.master')

@section('content')

@php
    $login_content        = getContent('login_page.content', true);
@endphp

<div class="account-section padding-bottom padding-top">
    <div class="contact-thumb d-none d-lg-block">
        <img src="{{ getImage('assets/images/frontend/login_page/'. @$login_content->data_values->image, '600x840') }}" alt="@lang('login-bg')">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="section-header left-style">
                    <h3 class="title">{{ __($login_content->data_values->title) }}</h3>
                    <p>{{ __($login_content->data_values->description) }}</p>
                </div>

                    <form method="POST" action="{{ route('user.login')}}" class="contact-form mb-30-none">
                        @csrf

                        <div class="contact-group">
                            <label for="username">@lang('Username')</label>
                            <input id="username" type="text" name="username" placeholder="@lang('Enter Your Username')" value="{{ old('username') }}">
                        </div>

                        <div class="contact-group">
                            <label for="password">@lang('Password')</label>
                            <input id="password" type="password" name="password" placeholder="@lang('Enter Your Password')" required autocomplete="current-password">
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
                            <button type="submit" id="recaptcha" class="custom-button m-0 ml-auto">@lang('Login')</button>
                        </div>



                        <div class="contact-group">
                            <div class="w-100">
                                <div class="m--10 d-flex flex-wrap align-items-center justify-content-between">
                                    @if (Route::has('user.register'))
                                    <span>@lang('Don\'t have an account')? <a href="{{route('user.register')}}">@lang('Create An Account')</a></span>
                                    @endif
                                    @if (Route::has('user.password.request'))
                                    <span class="account-alt">
                                        <a href="{{route('user.password.request')}}">
                                            {{ __('Forgot Password') }}?
                                        </a>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </form>

            </div>
        </div>
    </div>
</div>

@endsection


@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
@endpush

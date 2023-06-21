@extends($activeTemplate .'layouts.master')
@section('content')

@php
    $authorize_content  = getContent('authorize_email_page.content', true);
@endphp

<div class="account-section padding-bottom padding-top">
    <div class="contact-thumb d-none d-lg-block">
        <img src="{{ getImage('assets/images/frontend/authorize_email_page/'. @$authorize_content->data_values->image, '600x840') }}" alt="@lang('login-bg')">
    </div>
    <div class="container">

        <div class="row">
            <div class="col-lg-7">
                <div class="section-header left-style">
                    <h3 class="title">{{ __($authorize_content->data_values->title) }}</h3>
                        <p>{{ __($authorize_content->data_values->description) }}</p>
                </div>
                <form action="{{route('user.verify_email')}}" method="POST" class="contact-form mb-30-none">
                    @csrf
                    <div class="contact-group">
                        <label for="code">@lang('Verification Code')</label>
                        <input type="text" id="code" name="email_verified_code">
                    </div>

                    <div class="contact-group">
                        <button type="submit" class="custom-button m-0 ml-auto">@lang('Submit')</button>
                    </div>

                    <div class="contact-group justify-content-end">
                        <p>@lang('Please Check Junk/Spam Folder. If Not Found'), <a href="{{route('user.send_verify_code')}}?type=email" class="forget-pass"> @lang('Resend Code')</a></p>
                        @if ($errors->has('resend'))
                            <br/>
                            <small class="text-danger">{{ __($errors->first('resend')) }}</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends($activeTemplate.'layouts.master')

@section('content')
    @php
        $content = getContent('contact_page.content', true);
    @endphp



<!-- Contact Section Starts Here -->
<div class="contact-section padding-bottom padding-top oh position-relative">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-7">
                @if($content)
                <div class="section-header mb-low left-style">
                    <h3 class="title">@lang(@$content->data_values->title)</h3>
                    <p>@lang(@$content->data_values->description)</p>
                </div>
                @endif
                <form method="post" class="contact-form">
                    @csrf
                    <div class="contact-group">
                        <label for="name">@lang('Name')</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control h-50" required>
                    </div>
                    <div class="contact-group">
                        <label for="email">@lang('Email')</label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control h-50" required>
                    </div>

                    <div class="contact-group">
                        <label for="subject">@lang('Subject')</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="form-control h-50" required>

                    </div>
                    <div class="contact-group">
                        <label for="message">@lang('Message')</label>
                        <textarea name="message" id="message" class="form-control h-120" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="contact-group mb-0 justify-content-end">
                        <button type="submit" class="cmn-btn h-50">
                            @lang('Send Message')
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="contact--thumb">
                    <img src="{{ getImage('assets/images/frontend/contact_page/'. @$content->data_values->image, '800x964') }}" alt="@lang('login-bg')">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Section Ends Here -->
@endsection


@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
@endpush


@push('meta-tags')
    @include('partials.seo')
@endpush

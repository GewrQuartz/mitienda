@extends($activeTemplate .'layouts.master')
@section('content')

<div class="padding-bottom padding-top">
    <div class="container">
        @lang(@$data->data_values->description)
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
@endpush

@push('meta-tags')
    @include('partials.seo')
@endpush


@if(isset($seo_contents))
    <meta name="title" Content="{{ __($seo_contents['meta_title']??@$general->sitename(trans($page_title))) }}">
    <meta name="description" content="{{ __($seo_contents['meta_description']??@$seo->description) }}">
    <meta name="keywords" content="@if($seo_contents['meta_keywords'] != null)@foreach($seo_contents['meta_keywords'] as $key) {{ __($key) }},@endforeach @elseif(isset($seo->keywords)) {{ implode(',',$seo->keywords) }} @endif">

     {{--<!-- Facebook Meta Tags -->--}}
     <meta property="og:type" content="website">
     <meta property="og:title" content="{{ __($seo_contents['meta_title']??@$seo->social_title) }}">
     <meta property="og:description" content="{{ __($seo_contents['meta_description']??@$seo->social_description) }}">

     <meta property="og:image" content="{{ $seo_contents['image']??getImage(imagePath()['seo']['path'] .'/'. @$seo->image) }}"/>

     <meta property="og:image:type" content="{{ $seo_contents['image']??getImage(imagePath()['seo']['path'] .'/'. @$seo->image) }}" />

     @php
        if(isset($seo_contents['image_size']) && $seo_contents['image_size'] != null){
            $social_image_size = explode('x', $seo_contents['image_size']);
        }else {
            $social_image_size = explode('x', imagePath()['seo']['size']);
        }
     @endphp
     <meta property="og:image:width" content="{{ $social_image_size[0] }}" />
     <meta property="og:image:height" content="{{ $social_image_size[1] }}" />

     <meta property="og:url" content="{{ url()->current() }}">

@else
    @if(!empty($seo))
    <meta name="title" Content="{{ $general->sitename(trans($page_title)) }}">
    <meta name="description" content="{{ $seo->description }}">
    <meta name="keywords" content="{{ implode(',',$seo->keywords) }}">

    {{--<!-- Facebook Meta Tags -->--}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seo->social_title }}">
    <meta property="og:description" content="{{ $seo->social_description }}">
    <meta property="og:image" content="{{ getImage(imagePath()['seo']['path'] .'/'. @$seo->image) }}"/>
    @if($seo->image)
    <meta property="og:image:type" content="image/{{ pathinfo(getImage(imagePath()['seo']['path']) .'/'. @$seo->image)['extension'] }}" />
    @endif
    @php $social_image_size = explode('x', imagePath()['seo']['size']) @endphp
    <meta property="og:image:width" content="{{ $social_image_size[0] }}" />
    <meta property="og:image:height" content="{{ $social_image_size[1] }}" />
    <meta property="og:url" content="{{ url()->current() }}">

    @endif
@endif

{{--<!-- Twitter Meta Tags -->--}}
<meta name="twitter:card" content="summary_large_image">

{{--<!-- Apple Stuff -->--}}
<link rel="apple-touch-icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="{{ $general->sitename($page_title) }}">

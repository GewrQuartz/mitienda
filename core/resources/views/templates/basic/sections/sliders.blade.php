@php
    $sliders = getContent('sliders.element');
@endphp

@if($sliders && $sliders->count() > 0)
<div class="banner-section oh rounded--5 mb-30">
    <div class="banner-slider owl-theme owl-carousel">
        @foreach ($sliders as $slider)
        <a href="{{ @$slider->data_values->link }}" class="d-block">
            <div class="slide-item">
                    <img src="{{ getImage('assets/images/frontend/sliders/'. @$slider->data_values->slider, '1220x750') }}" alt="@lang('slider')">
                </div>
            </a>
        @endforeach
    </div>
    <div class="slide-progress"></div>
</div>
@endif

    @php
        $banners        = getContent('banners_middle.element');
    @endphp


    @if($banners->count()>0)
    <!-- Call to Action Section Starts Here -->
    <div class="call-to-section padding-top-half padding-bottom-half">
        <div class="container">
            <div class="row mb-30-none justify-content-center">

                @foreach ($banners as $banner)
                <div class="col-md-4 col-lg-4 mb-30">
                    <a href="{{ $banner->data_values->link }}" class="d-block overlay-effects">
                        <img src="{{ getImage('assets/images/frontend/banners_middle/'.$banner->data_values->image, '500x288') }}" class="w-100" alt="@lang('products-offer')">
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Call to Action Section Ends Here -->
    @endif

<section class="best-selling-section padding-bottom-half padding-top-half">
    <div class="container">
        <div class="section-header left-style mb-low">
            <h3 class="title">@lang('Top Seling Products')</h3>
        </div>
        <div class="row mb-30-none">
            @foreach ($products as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="best-sell-item">
                        <div class="best-sell-inner">
                            <div class="thumb">
                                <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}"><img src="{{ getImage(imagePath()['product']['path'].'/thumb_'.@$item->main_image, imagePath()['product']['size']) }}" alt="@lang('products-sell')"></a>
                            </div>
                            <div class="content">
                                <h6 class="title">
                                    <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">{{ __($item->name) }}</a>
                                </h6>
                                <div class="ratings-area justify-content-between">
                                    <div class="ratings">
                                        @php echo __(display_avg_rating($item->reviews)) @endphp
                                    </div>
                                    <span class="ml-2 mr-auto">({{ $item->reviews->count() }})</span>
                                </div>
                                <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}" class="read-more cl-1">@lang('View More')<i class="las la-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

<!-- Category Section Starts Here -->
<div class="category-section padding-bottom-half">
    <div class="container">
        <div class="row justify-content-between">
            @if($top_categories->count()>0)
                <div class="col-lg-6 padding-bottom-half padding-top-half">
                    <div class="section-header-2">
                        <h3 class="title">@lang('Top Categories')</h3>
                        <a href="{{ route('categories') }}" class="custom-button theme btn-sm">@lang('View All')</a>
                    </div>
                    <div class="m--10">
                        <div class="category-slider owl-theme owl-carousel">

                            @foreach ($top_categories as $item)
                                <div class="cate-item">
                                    <a href="{{ route('products.category', ['id'=>$item->id, 'slug'=>slug($item->name)]) }}" class="cate-inner">
                                        <img src="{{ getImage(imagePath()['category']['path'].'/'.@$item->image, imagePath()['category']['size']) }}" alt="@lang('products-category')">
                                        <span>{{ __($item->name) }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if($top_brands->count()>0)
                <div class="col-lg-6 padding-bottom-half padding-top-half">
                    <div class="section-header-2">
                        <h3 class="title">@lang('Top Brands')</h3>
                        <a href="{{ route('brands') }}" class="custom-button theme btn-sm">@lang('View All')</a>
                    </div>
                    <div class="m--10">
                        <div class="category-slider owl-theme owl-carousel">
                            @foreach ($top_brands as $item)
                                <div class="cate-item">
                                    <a href="{{ route('products.brand', ['id'=>$item->id, 'slug'=>slug($item->name)]) }}" class="cate-inner">
                                        <img src="{{ getImage(imagePath()['brand']['path'].'/'.@$item->logo, imagePath()['brand']['size']) }}" alt="@lang('products-category')">
                                        <span>{{ __($item->name) }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Category Section Ends Here -->

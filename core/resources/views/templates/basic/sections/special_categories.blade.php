<div class="oh mb-30">
    <div class="related-slider owl-carousel owl-theme">
        @foreach ($special_categories as $item)
        <a href="{{ route('products.category', ['id'=>$item->id, 'slug'=>slug($item->name)]) }}" class="d-block related-slide-item text-center">
            <div class="mb-10 oh rounded">
                <img src="{{ getImage(imagePath()['category']['path'].'/'.@$item->image, imagePath()['category']['size']) }}" class="w-100" alt="@lang('products-hot')">
            </div>
            <span class="line-limitation-1">{{ __($item->name) }}</span>
        </a>
        @endforeach
    </div>
</div>

<div class="oh">
    <div class="product-wrapper">
        @php
            $banners        = getContent('banners_top.element');
            $banners_small  = $banners->where('data_values.size', '340x275')->take(3)->values();
            $banners_large  = $banners->where('data_values.size', '340x518')->take(3)->values();
        @endphp
        @isset($banners_small[0])
        <div class="product-item">
            <div class="product-inner wish-buttons-in">
                <span class="badge badge--lg abs--badge badge-{{ $banners_small[0]->labelText($banners_small[0]->data_values->label_background) }}">{{ $banners_small[0]->data_values->label }}</span>

                <a href="{{ $banners_small[0]->data_values->link }}" class="w-100">
                    <img src="{{ getImage('assets/images/frontend/banners_top/'.$banners_small[0]->data_values->image, $banners_small[0]->data_values->size) }}" class="w-100" alt="@lang('products')">
                </a>

                <div class="product-content">
                    <div class="cont-top">
                        <h6 class="title">@lang(@$banners_small[0]->data_values->title)</h6>
                    </div>
                </div>
            </div>
        </div>
        @endisset
        @isset($banners_large[0])
        <div class="product-item">
            <div class="product-inner wish-buttons-in">
                <span class="badge badge--lg abs--badge badge-{{ $banners_large[0]->labelText($banners_large[0]->data_values->label_background) }}">{{ $banners_large[0]->data_values->label }}</span>

                <a href="{{ $banners_large[0]->data_values->link }}" class="w-100">
                    <img src="{{ getImage('assets/images/frontend/banners_top/'.$banners_large[0]->data_values->image, $banners_large[0]->data_values->size) }}" class="w-100" alt="@lang('products')">
                </a>

                <div class="product-content">
                    <div class="cont-top">
                        <h6 class="title">@lang(@$banners_large[0]->data_values->title)</h6>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        @isset($banners_small[1])
        <div class="product-item">
            <div class="product-inner wish-buttons-in">
                <span class="badge badge--lg abs--badge badge-{{ $banners_small[1]->labelText($banners_small[1]->data_values->label_background) }}">{{ $banners_small[1]->data_values->label }}</span>

                <a href="{{ $banners_small[1]->data_values->link }}" class="w-100">
                    <img src="{{ getImage('assets/images/frontend/banners_top/'.$banners_small[1]->data_values->image, $banners_small[1]->data_values->size) }}" class="w-100" alt="@lang('products')">
                </a>

                <div class="product-content">
                    <div class="cont-top">
                        <h6 class="title">@lang(@$banners_small[1]->data_values->title)</h6>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        @isset($banners_large[1])
        <div class="product-item">
            <div class="product-inner wish-buttons-in">
                <span class="badge badge--lg abs--badge badge-{{ $banners_large[1]->labelText($banners_large[1]->data_values->label_background) }}">{{ $banners_large[1]->data_values->label }}</span>

                <a href="{{ $banners_large[1]->data_values->link }}" class="w-100">
                    <img src="{{ getImage('assets/images/frontend/banners_top/'.$banners_large[1]->data_values->image, $banners_large[1]->data_values->size) }}" class="w-100" alt="@lang('products')">
                </a>

                <div class="product-content">
                    <div class="cont-top">
                        <h6 class="title">@lang($banners_large[1]->data_values->title)</h6>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        @isset($banners_large[2])
        <div class="product-item">
            <div class="product-inner wish-buttons-in">
                <span class="badge badge--lg abs--badge badge-{{ $banners_large[2]->labelText($banners_large[2]->data_values->label_background) }}">{{ $banners_large[2]->data_values->label }}</span>

                <a href="{{ $banners_large[2]->data_values->link }}" class="w-100">
                    <img src="{{ getImage('assets/images/frontend/banners_top/'.$banners_large[2]->data_values->image, $banners_large[2]->data_values->size) }}" class="w-100" alt="@lang('products')">
                </a>

                <div class="product-content">
                    <div class="cont-top">
                        <h6 class="title">{{ $banners_large[2]->data_values->title }}</h6>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        @isset($banners_small[2])
        <div class="product-item">
            <div class="product-inner wish-buttons-in">
                <span class="badge badge--lg abs--badge badge-{{ $banners_small[2]->labelText($banners_small[2]->data_values->label_background) }}">{{ $banners_small[2]->data_values->label }}</span>

                <a href="{{ $banners_small[2]->data_values->link }}" class="w-100">
                    <img src="{{ getImage('assets/images/frontend/banners_top/'.$banners_small[2]->data_values->image, $banners_small[2]->data_values->size) }}" class="w-100" alt="@lang('products')">
                </a>

                <div class="product-content">
                    <div class="cont-top">
                        <h6 class="title">{{ $banners_small[2]->data_values->title }}</h6>
                    </div>
                </div>
            </div>
        </div>
        @endisset

    </div>
</div>

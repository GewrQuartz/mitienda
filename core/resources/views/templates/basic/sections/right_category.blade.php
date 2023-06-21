
<div class="right-category">
        <h6 class="section-title d-xl-none">
            @lang('Special Products')
            <span class="close-category">
                <i class="las la-times"></i>
            </span>
        </h6>
        <div class="todays-deal">

            @foreach ($products as $item)
            @php
                if($item->offer && $item->offer->activeOffer){
                    $discount = calculateDiscount($item->offer->activeOffer->amount, $item->offer->activeOffer->discount_type, $item->base_price);
                }

                else $discount = 0;
             @endphp

            <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}" class="item">
                <div class="thumb">
                    <img src="{{ getImage(imagePath()['product']['path'].'/thumb_'.@$item->main_image, imagePath()['product']['size']) }}" alt="@lang('special')">
                </div>
                <div class="cont">
                    <span class="title" title="{{ __($item->name) }}">{{ __($item->name) }}</span>
                    <span class="price">
                        @if($discount > 0)
                        {{ $general->cur_sym }}{{ getAmount($item->base_price - $discount, 2) }}
                        <del>{{ getAmount($item->base_price, 2) }}</del>
                        @else
                        {{ $general->cur_sym }}{{ getAmount($item->base_price, 2) }}
                        @endif
                    </span>
                </div>
            </a>
            @endforeach

        </div>
</div>

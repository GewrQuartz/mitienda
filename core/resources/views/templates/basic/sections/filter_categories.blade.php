  <!-- Section Starts Here -->
  <div class="padding-bottom-half padding-top-half oh">
    <div class="container">
        <ul class="nav nav-tabs">
            @foreach ($f_categories as $f_category)
            <li>
                <a href="#cat-{{ $f_category->id }}" class="@if($loop->first) active @endif" data-toggle="tab">{{ __($f_category->name) }}</a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach ($f_categories as $f_category)
                <div class="tab-pane  @if($loop->first) show active fade @endif" id="cat-{{ $f_category->id }}">
                    <div class="m--15">
                        <div class="product-slider-2 owl-carousel owl-theme">
                            @foreach ($f_category->specialProuducts as $item)
                                @php
                                if($item->offer && $item->offer->activeOffer){
                                    $discount = calculateDiscount($item->offer->activeOffer->amount, $item->offer->activeOffer->discount_type, $item->base_price);
                                }else $discount = 0;
                                $wCk = checkWishList($item->id);
                                $cCk = checkCompareList($item->id);
                                @endphp
                                <div class="product-item-2">
                                    <div class="product-item-2-inner wish-buttons-in">
                                        <ul class="wish-react">
                                            <li>
                                            <a href="javascript:void(0)" title="@lang('Add To Wishlist')" class="add-to-wish-list {{$wCk?'active':''}}" data-id="{{$item->id}}"><i class="lar la-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="@lang('Compare') {{$cCk?'active':''}}" class="add-to-compare" data-id="{{$item->id}}"><i class="las la-sync-alt"></i></a>
                                            </li>
                                        </ul>
                                        <div class="product-thumb">
                                            <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">
                                                <img src="{{ getImage(imagePath()['product']['path'].'/thumb_'.@$item->main_image, imagePath()['product']['size']) }}" alt="@lang('flash')">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-before-content">
                                                <h6 class="title">
                                                    <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">{{ __($item->name) }}</a>
                                                </h6>
                                                <div class="ratings-area justify-content-between">
                                                    <div class="ratings">
                                                        @php echo __(display_avg_rating($item->reviews)) @endphp
                                                    </div>

                                                    <span class="ml-2 mr-auto">({{ __($item->reviews->count()) }})</span>
                                                    <div class="price">
                                                        @if($discount > 0)
                                                        {{ $general->cur_sym }}{{ getAmount($item->base_price - $discount, 2) }}
                                                        <del>{{ getAmount($item->base_price, 2) }}</del>
                                                        @else
                                                        {{ $general->cur_sym }}{{ getAmount($item->base_price, 2) }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-after-content">
                                                <button data-product="{{$item->id}}" class="cmn-btn btn-sm quick-view-btn">
                                                    @lang('View')
                                                </button>
                                                <div class="price">
                                                    @if($discount > 0)
                                                    {{ $general->cur_sym }}{{ getAmount($item->base_price - $discount, 2) }}
                                                    <del>{{ getAmount($item->base_price, 2) }}</del>
                                                    @else
                                                    {{ $general->cur_sym }}{{ getAmount($item->base_price, 2) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Section Ends Here -->

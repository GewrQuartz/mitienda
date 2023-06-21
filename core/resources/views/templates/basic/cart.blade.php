@extends(activeTemplate() .'layouts.master')
@section('content')
    <!-- cart-section start -->
    <div class="cart-section padding-bottom padding-top">
        <div class="container">
            @if($data->count()>0)
            <table class="order-list-table table cart-table m-0">
                <thead>
                    <tr>
                        <th>@lang('Product')</th>
                        <th>@lang('Variant')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Quantity')</th>
                        <th>@lang('Total')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                @php
                    $sub_total          = 0;
                    $product_categories = [];
                    $coupon_products    = $data->pluck('product_id')->unique()->toArray();
                @endphp

                @foreach ($data as $item)
                    @php
                        $product_categories [] = $item->product->categories->pluck('id')->toArray();

                        $attributes = $item->attributes??null;
                        if($attributes !==null){
                            sort($attributes);
                            $attributes = json_encode($attributes);
                        }
                        $stock_qty  = showAvailableStock($item->product_id, $attributes);
                    @endphp

                    <tr class="cart-row">
                        <td data-label="@lang('Product')">
                            <a href="{{route('product.detail', ['id'=>$item->product->id, 'slug'=>slug($item->product->name)])}}" class="cart-item">
                                <div class="cart-img">
                                    <img src="{{ getImage(imagePath()['product']['path'].'/'.@$item->product->main_image, imagePath()['product']['size']) }}" alt="@lang('product-image')">
                                </div>
                                <div class="cart-cont">
                                    <h6 class="title">{{__($item->product->name)}}</h6>
                                </div>
                            </a>
                        </td>

                        <td data-name="Variant">
                            @if($item->attributes != null)
                                @php echo cartAttributesShow($item->attributes) @endphp
                            @else
                                @lang('N\A')
                            @endif
                        </td>


                        <td data-label="@lang('Price')">
                            {{$general->cur_sym}}@php
                            if($item->attributes != null){
                                $s_price = priceAfterAttribute($item->product, $item->attributes);
                                echo getAmount($s_price, 2);
                            }else{
                                if($item->product->offer && $item->product->offer->activeOffer){
                                    $s_price = $item->product->base_price - calculateDiscount($item->product->offer->activeOffer->amount, $item->product->offer->activeOffer->discount_type, $item->product->base_price);
                                }else{
                                    $s_price = $item->product->base_price;
                                }
                                echo getAmount($s_price, 2);
                            }
                            @endphp
                        </td>

                        <td data-label="@lang('Quantity')">
                            <div class="cart-plus-minus p-0 flex-nowrap justify-content-center quantity">
                                <div class="cart-decrease qtybutton dec">
                                    <i class="las la-minus"></i>
                                </div>
                                <input type="number" data-id="{{$item->id}}" data-price="{{$s_price}}" class="qty integer-validation" type="number" min="1" step="1" value="{{$item['quantity']}}">
                                <div class="cart-increase qtybutton inc active">
                                    <i class="las la-plus"></i>
                                </div>
                            </div>
                        </td>

                        <td data-label="@lang('Total')" class="text-right">
                            <div>{{$general->cur_sym}}<span class="total_price">{{ getAmount($s_price*$item['quantity'], 2) }}</span>
                            </div>
                        </td>

                        <td data-label="@lang('Action')">
                            <a href="javascript:void(0)">
                                <span class="edit remove-cart" data-id="{{$item->id}}">
                                    <i class="las la-trash"></i>
                                </span>
                            </a>
                        </td>

                    </tr>
                @php $sub_total += $s_price*$item['quantity'] @endphp
                @endforeach
            </table>
            <div class="cart-total section-bg ">
                <div class="m--15 d-flex flex-wrap align-items-center justify-content-between">
                    <div class="apply-coupon-code">
                        @auth
                            <input type="text" name="coupon_code" placeholder="@lang('Enter Coupon Code')">
                            <button type="botton" name="coupon_apply">@lang('Apply Coupon')</button>
                        @endauth
                    </div>
                    <div class="total">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="sub--total">@lang('Subtotal')</div>
                            <span class="amount">{{$general->cur_sym}}<span id="cartSubtotal">{{getAmount($sub_total, 2)}}</span></span>
                        </div>
                        <div class="coupon-amount-total @if(!session()->has('coupon')) d-none @endif">
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="sub--total">

                                    <span class="mr-2 cl-theme remove-coupon"><i class="la la-times-circle"></i></span>

                                    <span>@lang('Coupon') (<b class="couponCode">{{@session('coupon')['code']}}</b>) </span>

                                </div>
                                <span class="amount">{{$general->cur_sym}}<span id="couponAmount"> {{@session('coupon')['amount']??0}}</span> </span>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="sub--total"><span>@lang('Total') </span></div>
                                <span class="amount">{{$general->cur_sym}}<span id="finalTotal">{{getAmount($sub_total- @session('coupon')['amount']??0 , 0)}}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout mt-3 d-flex justify-content-between">
                <a href="{{route('products')}}" class="theme custom-button">@lang('Continue Shopping')</a>
                <a href="{{route('user.checkout')}}" class="theme-2 custom-button">@lang('Checkout')</a>
            </div>
            @else
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ __($empty_message) }}</strong>
              </div>
            @endif
        </div>
    </div>
    <!-- cart-section end -->

@endsection
@push('script')
    <script>
    'use strict';
    (function($){
        var cartSubtotal = parseFloat('{{$sub_total??0}}');
        sessionStorage.setItem('subtotal', cartSubtotal);
        $('.quantity input[type=number]').on('keyup',function(){
            updateCart($(this), this.value)
        });
        $('.qtybutton').on('click',function(){
            var couponAmount = parseFloat($('#couponAmount').text()).toFixed(2);
            if(couponAmount > 0) {
                notify('error', 'You have applied a coupon on your cart. If you want to update your cart, at first remove the coupon.');
                return false;
            }
            var oldValue = $(this).parents('.cart-row').find('input[type=number]').val();
            if ($(this).hasClass('inc')) {
                var qty = parseFloat(oldValue) + 1;
            } else {
                if (oldValue > 1) {
                    var qty = parseFloat(oldValue) - 1;
                } else {
                    qty = 1;
                }
            }
            updateCart($(this), qty)
        });
        function updateCart(obj, qty) {
            var parent      = obj.parents('.cart-row');
            var sub_total   = formatNumber($('#cartSubtotal').text());
            var prev_total  = formatNumber(parent.find('.total_price').text());
            var price       = formatNumber(parent.find('input[type=number]').data('price'));
            var total       = qty*price;
            var dif         = total - parseFloat(prev_total);
            var subtotal    = (parseFloat(sub_total) + parseFloat(dif));
            var id          = $(parent).find('input[type=number]').data('id');
            var data        = {quantity:qty};
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                url: "{{route('update-cart-item', '')}}"+"/"+id,
                method:"post",
                data: data,
                success: function(response){
                    if(response.error){
                        $('.quantity input[type=number]').val(response.qty)
                        notify('error', response.error);
                    }else{
                        $('#cartSubtotal').text(parseFloat(subtotal).toFixed(2));
                        sessionStorage.setItem('subtotal', subtotal.toFixed(2));
                        parent.find('.total_price').text(parseFloat(total.toFixed(2)));
                        getCartTotal();
                        getCartData();
                        $('#finalTotal').text(parseFloat((subtotal - parseFloat($('#couponAmount').text())).toFixed(2)));
                    }
                }
            });
        }
        $(document).on('click', 'button[name=coupon_apply]', function(){
            var code = $('input[name=coupon_code]').val();
            var subtotal = formatNumber($('#cartSubtotal').text());
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                url: `{{ route('applyCoupon')}}`,
                method:"POST",
                data:{
                    code:code,
                    subtotal: subtotal,
                    categories: @json(@$product_categories),
                    products: @json(@$coupon_products)
                },
                success: function(response){
                    if(response.success) {
                        $('#couponAmount').text(response.amount);
                        $('#finalTotal').text(parseFloat((subtotal - response.amount).toFixed(2)));
                        $('.couponCode').text(response.coupon_code);
                        $('.coupon-amount-total').removeClass('d-none').hide().show('300');
                        getCartData();
                        notify('success', response.success);
                    }else if(response.error){
                        notify('error', response.error);
                    }else{
                        notify('error', response);
                    }
                }
            });
        });
        function formatNumber(number){
            if(typeof(number) != 'string'){
                return number;
            }
            return parseFloat(number.replace(/,/g, ''));
        }
    })(jQuery)
    </script>
@endpush

@push('breadcrumb-plugins')
<li><a href="{{route('home')}}">@lang('Home')</a></li>
<li><a href="{{route('products')}}">@lang('Products')</a></li>
@endpush

@push('meta-tags')
    @include('partials.seo')
@endpush

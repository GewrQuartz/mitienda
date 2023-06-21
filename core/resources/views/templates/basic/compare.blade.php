@extends($activeTemplate .'layouts.master')
@section('content')
<!-- section start -->
<div class="compare-section padding-bottom padding-top">
    <div class="container">
        <div class="oh">
            <div class="compare-table-wrapper">

                @if($compare_items->count()>0)
                <table class="compare-table">
                    <tbody>

                        <tr class="th-compare">
                            @foreach ($compare_items->pluck('id') as $item)
                            <th class="product-{{ $item }} text-right" >
                                <button type="button" data-pid="{{$item}}" class="remove-compare"><i class="las la-trash"></i></button>
                            </th>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach ($compare_items as $item)
                            <td class="align-top product-{{ $item->id }}">
                                <div class="compare-thumb">
                                    <img src="{{ getImage(imagePath()['product']['path'].'/'.@$item->main_image, imagePath()['product']['size']) }}" alt="@lang('featured')">
                                </div>
                                <div class="name">
                                    {{ $item->name }}
                                </div>
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach ($compare_items as $item)

                            <td class="p-0 product-{{ $item->id }}">
                                <ul class="compare-specification">
                                    @if($item->specification)
                                        @foreach ($item->specification as $specification)
                                        <li>
                                            <span class="title">{{ @$specification['name'] }}</span>
                                            <span class="info">{{ @$specification['value'] }}</span>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach ($compare_items as $item)
                            @php
                                if($item->offer && $item->offer->activeOffer){
                                    $discount = calculateDiscount($item->offer->activeOffer->amount, $item->offer->activeOffer->discount_type, $item->base_price);
                                }else $discount = 0;
                            @endphp
                            <td class="p-0 product-{{ $item->id }}">
                                <ul class="compare-specification">
                                    <li><span class="title">@lang('Price')</span>

                                    <span class="info"> @if($discount > 0)
                                        {{ $general->cur_sym }}{{ getAmount($item->base_price - $discount, 2) }}
                                        <del>{{ getAmount($item->base_price, 2) }}</del>
                                        @else
                                        {{ $general->cur_sym }}{{ getAmount($item->base_price, 2) }}
                                        @endif</span>

                                    </li>
                                </ul>
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach ($compare_items as $item)
                            <td class="p-0 product-{{ $item->id }}">
                                <ul class="compare-specification">
                                    <li><span class="title">@lang('Availability')</span>
                                    @if($item->stocks->sum('quantity') > 0)
                                    <span class="text-success info">@lang('Available in Stock')</span>
                                    @else
                                    <span class="text-danger info">@lang('Not Available in Stock')</span>
                                    @endif
                                    </li>
                                </ul>
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach ($compare_items as $item)
                                <td class="product-{{ $item->id }}"><a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}" class="cmn-btn btn-block">@lang('Buy Now')</a></td>
                            @endforeach
                        </tr>


                    </tbody>
                </table>
                @else
                    @if($compare_items->count() == 0)
                        <div class="col-lg-12 mb-30">
                            @include($activeTemplate.'partials.empty_message', ['message' => __($empty_message)])
                        </div>
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>
<!-- Section ends -->


@endsection

@push('breadcrumb-plugins')
    <li><a href="{{route('home')}}">@lang('Home')</a></li>
@endpush

@push('script')
    <script>
        'use strict';
        (function($){
            $('.remove-compare').on('click', function(){
                var id = $(this).data('pid');
                var className = `.product-${id}`;

                var data = {id:id};
                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    url: "{{route('del-from-compare', '')}}"+"/"+id,
                    method:"post",
                    data: data,
                    success: function(response){
                        if(response.message) {
                            notify('success', response.message);
                            getCompareData();
                            $(document).find(className).hide('300')
                        }else{
                            notify('error', response.error);
                        }
                    }
                });
            });

        })(jQuery)
    </script>
@endpush


@push('meta-tags')
    @include('partials.seo')
@endpush

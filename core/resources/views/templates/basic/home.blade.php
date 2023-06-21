@extends($activeTemplate.'layouts.master')
@section('content')

<!-- tochat.be widget -->					
<script src="https://apps.elfsight.com/p/platform.js" defer></script>
<div class="elfsight-app-2c55f632-cf2e-4e23-ac68-7153db444e13"></div>
<!-- /tochat.be widget -->

    <div class="main-sections oh">

        {{-- Left Category Menu --}}
        @include($activeTemplate.'sections.left_category_menu')

        <div class="all-sections">
            @include($activeTemplate.'sections.sliders')

            @include($activeTemplate.'sections.special_categories', ['special_categories' => $special_categories])
            @include($activeTemplate.'sections.banners_top')
        </div>
        @include($activeTemplate.'sections.right_category', ['products' => $special_products])
    </div>


    @include($activeTemplate.'sections.newsletter', ['offers'=> $offers])
    @include($activeTemplate.'sections.offers')
    @include($activeTemplate.'sections.banners_middle')

    @if($featured_products->count()>0)
        @include($activeTemplate.'sections.featured_products', ['featured_products'=> $featured_products])
    @endif
    @php
        $f_categories = $categories->where('in_filter_menu');
    @endphp

    @if($f_categories->count()> 0)
        @include($activeTemplate.'sections.filter_categories', ['f_categories'=> $f_categories])
    @endif

    @if($top_selling_products->count() > 0)
    @include($activeTemplate.'sections.top_selling_products', ['products'=> $top_selling_products])
    @endif
    @include($activeTemplate.'sections.top_categories_brands', ['top_categories'=> $top_categories, 'top_brands' => $top_brands])

@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            //ADD TO CART
        $(document).on('click','.subscribe-btn' , function(){
            var email    = $('input[name="email"]').val();

            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('subscribe') }}",
                method:"POST",
                data:{email:email},
                success:function(response)
                {
                    if(response.success) {
                        notify('success', response.success);
                    }else{
                        notify('error', response);
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

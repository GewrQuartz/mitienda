<li>
    <a href="{{ route('products.category', ['id'=>$subcategory->id, 'slug'=>slug($subcategory->name)]) }}">
        @php echo $subcategory->icon @endphp {{ __($subcategory->name) }}
    </a>

    @if ($subcategory->allSubcategories)
    <div class="cate-icon">
        <i class="las la-angle-down"></i>
    </div>
    @if($subcategory->allSubcategories->count() >0)
    <ul class="sub-category">
        @foreach ($subcategory->allSubcategories as $childCategory)
            @include($activeTemplate.'partials.menu_subcategories', ['subcategory' => $childCategory])
        @endforeach
    </ul>
    @endif
    @endif
</li>

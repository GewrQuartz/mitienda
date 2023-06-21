
<div class="left-category home-category active d-none d-xl-block">
    @if($categories->count()>0)

    <ul class="categories">
        @foreach ($categories as $category)
        <li>
            <a href="{{ route('products.category', ['id'=>$category->id, 'slug'=>slug($category->name)]) }}">
                @php echo $category->icon @endphp {{ __($category->name) }}
            </a>
            <ul class="sub-category">
                @foreach ($category->allSubcategories as $subcategory)
                    @include($activeTemplate.'partials.menu_subcategories', ['subcategory' => $subcategory])
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
    @endif
</div>

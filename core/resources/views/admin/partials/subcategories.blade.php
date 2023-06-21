

@if ($subcategory->allSubcategories)
@php $prefix .='|--'  @endphp
    @foreach ($subcategory->allSubcategories as $childCategory)
        <option value="{{ $subcategory->id }}" > {{ $prefix }} @lang($subcategory->name)</option>
        @include('admin.partials.subcategories', ['subcategory' => $childCategory])
    @endforeach
@endif

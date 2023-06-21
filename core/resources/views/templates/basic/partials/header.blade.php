
    <!-- Header Section Starts Here -->
    <header>
        <div class="header-top bg-3 py-1 border-bottom-1 d-none d-lg-block">
            <div class="container">
                <div class="header-top-wrap d-flex flex-wrap justify-content-between align-items-center">
                    <div class="right-side">
                        <ul>

                            @if($pages->count() > 0)
                                @foreach ($pages as $item)
                                    <li><a href="{{route('pages', ['id' => $item->id, 'slug'=> slug($item->data_values->page_title) ])}}">@php echo __($item->data_values->page_title) @endphp</a></li>
                                @endforeach
                            @endif

                            <li><a href="{{route('order-track')}}">@lang('Track Your Order')</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle bg-white py-3">
            <div class="container">
                <div class="header-wrapper justify-content-between align-items-center">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="{{ getImage('assets/images/logoIcon/logo.png', '183x54') }}" alt="@lang('logo')">
                        </a>
                    </div>
                    <ul class="menu ml-auto d-none d-lg-flex">
                        <li>
                            <a href="{{route('home')}}">@lang('Home')</a>
                        </li>

                        <li>
                            <a href="{{ route('products') }}">@lang('Products')</a>
                        </li>

                        <li>
                            <a href="{{ route('brands') }}">@lang('Brands')</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>
                    </ul>
                    <div class="header-bar d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom bg-3 py-3">
            <div class="container">
                <div class="header-bottom-wrapper d-flex flex-wrap justify-content-between align-items-center">
                    <div class="view-category d-none d-lg-block  @if(request()->routeIs('home')) d-xl-none @endif">
                        <a href="javascript:void(0)">@lang('Categories')<i class="las la-angle-down"></i></a>
                    </div>
                    <form action="{{route('product.search')}}" method="GET" class="header-search-form mr-auto @if(!request()->routeIs('home')) w-100 @endif" >
                        <div class="header-form-group">
                            <input type="text" name="search_key" value="{{request()->search_key}}" placeholder="@lang('Search')...">
                            <button type="submit"><i class="las la-search"></i></button>
                        </div>
                        <div class="select-item">
                            <select class="select-bar" name="category_id">
                                <option selected value="0">@lang('All Categories')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">@lang($category->name)</option>
                                    @php
                                        $prefix = '--'
                                    @endphp
                                    @foreach ($category->allSubcategories as $subcategory)
                                        @include($activeTemplate.'partials.subcategories', ['subcategory' => $subcategory, 'prefix'=>$prefix])
                                        <option value="{{ $subcategory->id }}">
                                            {{ $prefix }}@lang($subcategory->name)
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </form>
                    @if(request()->routeIs('home'))
                        <div class="right-toggle text-right d-xl-none">
                            <i class="las la-ellipsis-v"></i>
                        </div>
                    @endif
                    <ul class="shortcut-icons">
                        <li>
                            <a href="javascript:void(0)" class="dashboard-menu-bar">
                                <i class="las la-user"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('compare')}}">
                                <i class="las la-sync-alt"></i>
                                <span class="compare-count amount">0</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="wish-button">
                                <i class="lar la-heart"></i>
                                <span class="wishlist-count amount">0</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="cart-button">
                                <i class="las la-shopping-bag"></i>
                                <span class="cart-count amount">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="pos-rel d-none d-lg-block @if(request()->routeIs('home')) d-xl-none @endif">
                    <div class="left-category single-style">
                        <ul class="categories">
                            @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('products.category', ['id'=>$category->id, 'slug'=>slug($category->name)]) }}">
                                    @php echo $category->icon @endphp {{ $category->name }}
                                </a>

                                <div class="cate-icon">
                                    <i class="las la-angle-down"></i>
                                </div>
                                @if($category->allSubcategories->count() > 0)
                                <ul class="sub-category">
                                    @foreach ($category->allSubcategories as $subcategory)
                                        @include($activeTemplate.'partials.menu_subcategories', ['subcategory' => $subcategory])
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="mobile-menu d-lg-none">
        <div class="mobile-menu-header">
            <div class="mobile-menu-close">
                <i class="las la-times"></i>
            </div>
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ getImage('assets/images/logoIcon/logo_2.png', '183x54') }}" alt="@lang('logo')">
                </a>
            </div>
        </div>
        <ul class="nav-tabs nav border-0">
            <li>
                <a href="#menu" class="active" data-toggle="tab">@lang('Menu')</a>
            </li>
            <li>
                <a href="#cate" data-toggle="tab">@lang('Category')</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="menu">
                <div class="mobile-menu-body">
                    <ul class="menu mt-4">
                        <li>
                            <a href="{{route('home')}}">@lang('Home')</a>
                        </li>

                        <li>
                            <a href="{{ route('products') }}">@lang('Products')</a>
                        </li>

                        <li>
                            <a href="{{ route('brands') }}">@lang('Brands')</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>
                    </ul>
                </div>
                <div class="quick-links mt-4">
                    <ul>
                        @if($pages->count() > 0)
                            @foreach ($pages as $item)
                                <li><a href="{{route('pages', ['id' => $item->id, 'slug'=> slug($item->data_values->page_title) ])}}">@php echo __($item->data_values->page_title) @endphp</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="cate">
                <div class="left-category single-style">
                    <ul class="categories">
                        @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('products.category', ['id'=>$category->id, 'slug'=>slug($category->name)]) }}">
                                @php echo $category->icon @endphp {{ $category->name }}
                            </a>
                            <div class="cate-icon">
                                <i class="las la-angle-down"></i>
                            </div>

                            @if($category->allSubcategories->count()>0)
                            <ul class="sub-category">
                                @foreach ($category->allSubcategories as $subcategory)
                                    @include($activeTemplate.'partials.menu_subcategories', ['subcategory' => $subcategory])
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ===========Cart=========== -->
    <div id="body-overlay" class="body-overlay"></div>
    <div class="cart-sidebar-area" id="cart-sidebar-area">
        <div class="top-content">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ getImage('assets/images/logoIcon/logo_2.png', '183x54') }}" alt="@lang('logo')">
            </a>
            <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
        </div>
        <div class="bottom-content">
            <div class="cart-products cart--products">


            </div>
        </div>
    </div>
    <!-- ===========Cart End=========== -->

    <!-- ===========Wishlist=========== -->
    <div class="cart-sidebar-area" id="wish-sidebar-area">
        <div class="top-content">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ getImage('assets/images/logoIcon/logo_2.png', '183x54') }}" alt="@lang('logo')">
            </a>
            <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
        </div>
        <div class="bottom-content">
            <div class="cart-products wish-products">

            </div>
        </div>
    </div>
    <!-- ===========Wishlist End=========== -->

    <!-- Header Section Ends Here -->
    <div class="dashboard-menu before-login-menu d-flex flex-wrap justify-content-center flex-column">
        <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
        @guest
        <div class="login-wrapper py-5 px-4">
            <h4 class="subtitle cl-white">@lang('My Account')</h4>
            <form method="POST" action="{{ route('user.login')}}" class="sign-in-form">
                @csrf
                <div class="form-group">
                    <label for="login-username">@lang('Username')</label>
                    <input type="text" class="form-control" name="username" id="login-username" value="{{ old('email') }}" placeholder="@lang('Username')">
                </div>
                <div class="form-group">
                    <label for="login-pass">@lang('Password')</label>
                    <input type="password" class="form-control" name="password" id="login-pass" placeholder="********">
                </div>

                @php $captcha =   getCustomCaptcha('login captcha') @endphp

                @if($captcha)
                <div class="form-group">
                    <label for="password">@lang('Captcha')</label>
                    <input type="text" class="mb-4" name="captcha" autocomplete="off" placeholder="@lang('Enter The Code Below')">
                    @lang($captcha)
                </div>
                @endif

                <div class="form-group text-right pt-2">
                    <button type="submit" class="login-button">@lang('Login')</button>
                </div>

                <div class="pt-2 mb-0">
                    <p class="create-accounts">
                        <a href="{{route('user.password.request')}}" class="mb-2">@lang('Forgot Password')?</a>
                    </p>
                    <p class="create-accounts">
                        <span>@lang('Don\'t have an account')? <a href="{{route('user.register')}}" class="link-color">@lang('Create An Account')</a> </span>
                    </p>
                </div>
            </form>
        </div>
        @endguest

        @auth
        @include($activeTemplate.'user.partials.dp')
        <ul class="cl-white">
            @include($activeTemplate.'user.partials.sidebar')
        </ul>
        @endauth


    </div>

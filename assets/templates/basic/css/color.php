<?php header("Content-type:text/css; charset:UTF-8");
$color1=$_GET['color1'];
$color2=$_GET['color2'];

function checkhexcolor($c) {
    return preg_match('/^[a-f0-9]{6}$/i', $c);
}

if (isset($_GET['color1']) && !empty($_GET['color1']) && checkhexcolor($_GET['color1'])) {
    $color1='#'. $_GET['color1'];
}

if ( !$color1) {
    $color1="#faa603";
}

if (isset($_GET['color2']) && !empty($_GET['color2']) && checkhexcolor($_GET['color2'])) {
    $color2='#'. $_GET['color2'];
}

if ( !$color2) {
    $color2="#faa603";
}
?>

.bg-3,
.left-category .categories li a:hover,
.custom-button.theme,
.cart-sidebar-area,
.wish-react li a.active,
.wish-react li button,
.wish-react li a.active:hover,
.wish-react li button.active:hover,
.cmn-btn,
.cart-plus-minus .cart-decrease:hover,
.cart-plus-minus .cart-decrease.active,
.cart-plus-minus .cart-increase:hover,
.cart-plus-minus .cart-increase.active,
.view-number li.active .bar,
.view-style li a.active,
.widget .ui-slider-range,
.widget .ui-state-default,
.product-details .product-size-area .product-single-size.active,
.product-share a,
.product-details-wishlist a,
.order-track-form-group button,
.main-sections .section-title,
.mobile-menu,
.contact-group .custom-button,
.file-input-btn,
.bill-button,
.apply-coupon-code button,
.cart-table tr th,
.preloader{ background-color: <?php echo $color1 ?>!important} a,
.left-category .categories li a i,
.todays-deal .item .cont .price,
.filter-category li a:hover,
.filter-category li a.active, .text--secondary{ color: <?php echo $color1 ?>} .custom-button.theme,
.cart-plus-minus .cart-decrease:hover,
.cart-plus-minus .cart-decrease.active,
.cart-plus-minus .cart-increase:hover,
.cart-plus-minus .cart-increase.active,
.product-details .product-size-area .product-single-size.active,
.product-details .product-color-area .product-single-color.active,
.admin-support-ticket{ border-color: <?php echo $color1 ?>!important} .cart-sidebar-area .custom-button:hover,
.slide-progress,
.scrollToTop,
.subscribe-form button,
.social-icons li a:hover,
.custom-button.theme-2,
.shortcut-icons li a .amount,
.filter-in,
.cmn-btn-2,
.remove-item-button,
.nav-tabs li a.active,
.owl-dots .owl-dot.active, .captcha{ background-color: <?php echo $color2 ?>!important} .link-color,
.countdown li .countdown-title,
.product-item-2-inner .product-content .price,
h1 a:hover,
h2 a:hover,
h3 a:hover,
h4 a:hover,
h5 a:hover,
h6 a:hover,
.product-details-content .price,
.cate-inner:hover,
.breadcrumb li a,
.total .amount,
.contact-group .account-alt a,
.todays-deal .item .cont .title:hover,
.related-slide-item:hover{ color: <?php echo $color2 ?>!important} .user-support-ticket,
.cart-sidebar-area .custom-button:hover,
.custom-button.theme-2,
.dashboard-menu ul li a:hover,
.dashboard-menu ul li a.active{ border-color: <?php echo $color2 ?>!important} .menu li a{ color: #000} body *::-webkit-scrollbar,
body *::-webkit-scrollbar-button,
body *::-webkit-scrollbar-thumb{ background-color: <?php echo $color1 ?>!important} *::selection{ background-color: <?php echo $color2 ?>!important} @media (min-width:1200px){ .dashboard-menu.before-login-menu{ background-color: <?php echo $color1 ?>!important}} .view-number li .bar,
.user-profile .content{ background-color: <?php echo $color1 ?>36 !important} .order-track-item.active .thumb{ background: #27ae60 !important} .order-track-item.active .thumb i{ color: #27ae60 !important} @media (max-width:991px){ .shortcut-icons{ background: <?php echo $color1 ?>}} @media (max-width:1199px){ .dashboard-menu{ background: <?php echo $color1 ?>}} @media (max-width:991px){ .menu li a{ color: #ffffff} .payment-table tbody tr{ border-bottom: 1px solid <?php echo $color1 ?>}} body *::-webkit-scrollbar-track{ -webkit-box-shadow: inset 0 0 <?php echo $color1 ?>29; box-shadow: inset 0 0 6px <?php echo $color1 ?>29} @media (max-width:1199px){ .left-category .categories>li>.sub-category::before{ background: <?php echo $color1 ?>29}} .language_setting ul li a{ border-left: 2px solid <?php echo $color1 ?>; border-right: 2px solid <?php echo $color1 ?>} .widget-check-group input:checked::after{ border-color: <?php echo $color1 ?>; background: <?php echo $color1 ?>} .spinner{ border-top: 4px solid <?php echo $color1 ?>} .spinner-border{ border: .25em solid <?php echo $color2 ?>; border-right-color: transparent !important} .pagination .page-item.disabled span{ background-color: <?php echo $color1 ?>4d} .pagination .page-item.active span,
.pagination .page-item.active a,
.pagination .page-item:hover span,
.pagination .page-item:hover a{ color: <?php echo $color1 ?>} .pagination .page-item a,
.pagination .page-item span{ background-color: <?php echo $color1 ?>} .alert--base{ background: <?php echo $color1 ?>12;}

.modal-content {
   border: 10px solid <?php echo $color1 ?>;
}
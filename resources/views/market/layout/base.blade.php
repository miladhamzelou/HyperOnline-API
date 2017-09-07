<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="format-detection" content="telephone=09182180519"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{ asset('market/image/favicon.png')}}" rel="icon"/>
    <title>هایپرآنلاین</title>
    <meta name="description" content="سامانه فروش محصولات آنلاین">
    <!-- CSS Part Start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('market/js/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/js/bootstrap/css/bootstrap-rtl.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/stylesheet.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/owl.carousel.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/owl.transitions.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/responsive.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/stylesheet-rtl.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/responsive-rtl.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('market/css/mine.css')}}"/>
    <!-- CSS Part End-->
</head>
<body>
<div class="wrapper-wide">
    <div id="header">
        <!-- Top Bar Start-->
        <nav id="top" class="htop">
            <div class="container">
                <div class="row"><span class="drop-icon visible-sm visible-xs"><i
                                class="fa fa-align-justify"></i></span>
                    <div class="pull-left flip left-top">
                        <div class="links">
                            <ul>
                                <li class="mobile"><i class="fa fa-phone"></i>081-32221002</li>
                                <li class="email"><a href="mailto:hyperonlineir@gmail.com"><i
                                                class="fa fa-envelope"></i>hyperonlineir@gmail.com</a></li>
                                <li><a href="checkout.html">تسویه حساب</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="top-links" class="nav pull-right flip">
                        <ul>
                            <li><a href="login.html">ورود</a></li>
                            <li><a href="register.html">ثبت نام</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Top Bar End-->
        <!-- Header Start-->
        <header class="header-row">
            <div class="container">
                <div class="table-container">
                    <!-- Logo Start -->
                    <div class="col-table-cell col-lg-6 col-md-6 col-sm-12 col-xs-12 inner">
                        <div id="logo"><a href="index.html"><img class="img-responsive"
                                                                 src="{{ asset('market/image/logo.png')}}"
                                                                 title="MarketShop" alt="MarketShop"/></a></div>
                    </div>
                    <!-- Logo End -->
                    <!-- Mini Cart Start-->
                    <div class="col-table-cell col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div id="cart">
                            <button type="button" data-toggle="dropdown" data-loading-text="Loading..."
                                    class="heading dropdown-toggle">
                                <span class="cart-icon pull-left flip"></span>
                                <span id="cart-total">2 آیتم - 132000 تومان</span></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-center"><a href="product.html"><img class="img-thumbnail"
                                                                                                title="کفش راحتی مردانه"
                                                                                                alt="کفش راحتی مردانه"
                                                                                                src="{{ asset('market/image/product/sony_vaio_1-50x50.jpg')}}"></a>
                                            </td>
                                            <td class="text-left"><a href="product.html">کفش راحتی مردانه</a></td>
                                            <td class="text-right">x 1</td>
                                            <td class="text-right">32000 تومان</td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-xs remove" title="حذف" onClick=""
                                                        type="button"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><a href="product.html"><img class="img-thumbnail"
                                                                                                title="تبلت ایسر"
                                                                                                alt="تبلت ایسر"
                                                                                                src="{{ asset('market/image/product/samsung_tab_1-50x50.jpg')}}"></a>
                                            </td>
                                            <td class="text-left"><a href="product.html">تبلت ایسر</a></td>
                                            <td class="text-right">x 1</td>
                                            <td class="text-right">98000 تومان</td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-xs remove" title="حذف" onClick=""
                                                        type="button"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <li>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <td class="text-right"><strong>جمع کل</strong></td>
                                                <td class="text-right">132000 تومان</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>کسر هدیه</strong></td>
                                                <td class="text-right">4000 تومان</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>مالیات</strong></td>
                                                <td class="text-right">11880 تومان</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>قابل پرداخت</strong></td>
                                                <td class="text-right">139880 تومان</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p class="checkout"><a href="cart.html" class="btn btn-primary"><i
                                                        class="fa fa-shopping-cart"></i> مشاهده سبد</a>&nbsp;&nbsp;&nbsp;<a
                                                    href="checkout.html" class="btn btn-primary"><i
                                                        class="fa fa-share"></i> تسویه حساب</a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Mini Cart End-->
                    <!-- جستجو Start-->
                    <div class="col-table-cell col-lg-3 col-md-3 col-sm-6 col-xs-12 inner">
                        <div id="search" class="input-group">
                            <input id="filter_name" type="text" name="search" value="" placeholder="جستجو"
                                   class="form-control input-lg"/>
                            <button type="button" class="button-search"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <!-- جستجو End-->
                </div>
            </div>
        </header>
        <!-- Header End-->
        <!-- Main آقایانu Start-->
        <div class="container">
            <nav id="menu" class="navbar">
                <div class="navbar-header"><span class="visible-xs visible-sm"> منو <b></b></span></div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li><a class="home_link" title="خانه" href="index.html"><span>خانه</span></a></li>
                        <li class="mega-menu dropdown"><a>دسته ها</a>
                            <div class="dropdown-menu">
                                <div class="column col-lg-2 col-md-3"><a href="category.html">البسه</a>
                                    <div>
                                        <ul>
                                            <li><a href="category.html">آقایان <span>&rsaquo;</span></a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a href="category.html">زیردسته ها</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="contact-link"><a href="contact-us.html">تماس با ما</a></li>
                        <li class="custom-link-right"><a href="#" target="_blank"> همین حالا بخرید!</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Main آقایانu End-->
    </div>
    <div id="container">
        <!-- Feature Box Start-->
        <div class="container">
            <div class="custom-feature-box row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="feature-box fbox_1">
                        <div class="title">ارسال رایگان</div>
                        <p>برای خرید های بیش از 100 هزار تومان</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="feature-box fbox_2">
                        <div class="title">پس فرستادن رایگان</div>
                        <p>بازگشت کالا تا 24 ساعت پس از خرید</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="feature-box fbox_3">
                        <div class="title">کارت هدیه</div>
                        <p>بهترین هدیه برای عزیزان شما</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="feature-box fbox_4">
                        <div class="title">امتیازات خرید</div>
                        <p>از هر خرید امتیاز کسب کرده و از آن بهره بگیرید</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature Box End-->
        <div class="container">
            <div class="row">
                <!-- Left Part Start-->
                <aside id="column-left" class="col-sm-3 hidden-xs">
                    <h3 class="subtitle">دسته ها</h3>
                    <div class="box-category">
                        <ul id="cat_accordion">
                            @foreach($categories as $c1)
                                <li><a href="category.html">{{ $c1['name'] }}</a>
                                    @if($c1['child'])
                                        <span class="down"></span>
                                    @endif
                                    <ul>
                                        @foreach($c1['child'] as $c2)
                                            <li><a href="category.html">{{ $c2['name'] }}</a>
                                                @if($c2['child'])
                                                    <span class="down"></span>
                                                @endif
                                                <ul>
                                                    @foreach($c2['child'] as $c3)
                                                        <li><a href="category.html">{{ $c3['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <h3 class="subtitle">پرفروش ها</h3>
                    <div class="side-item">
                        <div class="product-thumb clearfix">
                            <div class="image"><a href="product.html"><img
                                            src="{{ asset('market/image/product/apple_cinema_30-50x50.jpg')}}"
                                            class="img-responsive"/></a></div>
                            <div class="caption">
                                <h4><a href="product.html">تی شرت کتان مردانه</a></h4>
                                <p class="price"><span class="price-new">110000 تومان</span> <span class="price-old">122000 تومان</span>
                                    <span class="saving">-10%</span></p>
                            </div>
                        </div>
                    </div>
                    <h3 class="subtitle">جدیدترین</h3>
                    <div class="side-item">
                        @foreach($new as $product)
                            <div class="product-thumb clearfix">
                                <div class="image">
                                    <a href="product.html">
                                        @if($product->image)
                                            <img src="{{ asset('images/') . $product->image }}" class="img-responsive"/>
                                        @else
                                            <img src="{{ asset('market/image/no_image.jpg') }}"
                                                 class="img-responsive"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="caption">
                                    <h4><a href="product.html">{{ $product->name }}</a></h4>
                                    @if($product->off > 0)
                                        <p class="price"><span
                                                    class="price-new">{{ round($product->price - ($product->price * $product->off / 100)) . ' تومان' }}</span>
                                            <span class="price-old">{{ $product->price . ' تومان' }}</span>
                                            <span class="saving">{{ $product->off }}%-</span>
                                        </p>
                                    @else
                                        <p class="price"><span class="price-new">{{ $product->price . ' تومان' }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>
                <!-- Left Part End-->
                <!--Middle Part Start-->
                <div id="content" class="col-sm-9">
                    <!-- Slideshow Start-->
                    <div class="slideshow single-slider owl-carousel">
                        <div class="item"><a href="#"><img class="img-responsive"
                                                           src="{{ asset('market/image/slider/banner-1.jpg')}}"
                                                           alt="banner 1"/></a></div>
                        <div class="item"><a href="#"><img class="img-responsive"
                                                           src="{{ asset('market/image/slider/banner-2.jpg')}}"
                                                           alt="banner 2"/></a></div>
                        <div class="item"><a href="#"><img class="img-responsive"
                                                           src="{{ asset('market/image/slider/banner-3.jpg')}}"
                                                           alt="banner 3"/></a></div>
                    </div>
                    <!-- Slideshow End-->
                    <!-- Featured محصولات Start-->
                    <h3 class="subtitle">ویژه</h3>
                    <div class="owl-carousel product_carousel">
                        <div class="product-thumb clearfix">
                            <div class="image"><a href="product.html"><img
                                            src="{{ asset('market/image/product/apple_cinema_30-200x200.jpg')}}"
                                            alt="تی شرت کتان مردانه"
                                            title="تی شرت کتان مردانه" class="img-responsive"/></a></div>
                            <div class="caption">
                                <h4><a href="product.html">تی شرت کتان مردانه</a></h4>
                                <p class="price">
                                    <span class="price-old">122000 تومان</span>
                                    <br>
                                    <span class="price-new">110000 تومان</span>
                                    <span class="saving" style="direction: rtl">10%-</span>
                                </p>
                            </div>
                            <div class="button-group">
                                <button class="btn-primary" type="button" onClick="cart.add('42');">
                                    <span>افزودن به سبد</span></button>
                            </div>
                        </div>
                    </div>
                    <!-- Featured محصولات End-->
                    <!-- Banner Start-->
                    <div class="marketshop-banner">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><a href="#"><img
                                            src="{{ asset('market/image/banner/sample-banner-3-400x200.jpg')}}"
                                            alt="بنر نمونه 3"
                                            title="بنر نمونه 3"/></a></div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><a href="#"><img
                                            src="{{ asset('market/image/banner/sample-banner-1-400x200.jpg')}}"
                                            alt="بنر نمونه"
                                            title="بنر نمونه"/></a></div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><a href="#"><img
                                            src="{{ asset('market/image/banner/sample-banner-2-400x200.jpg')}}"
                                            alt="بنر نمونه 2"
                                            title="بنر نمونه 2"/></a></div>
                        </div>
                    </div>
                    <!-- Banner End-->
                    <!-- دسته ها محصولات Slider Start-->
                    <div class="category-module" id="latest_category">
                        <h3 class="subtitle">الکترونیکی - <a class="viewall" href="category.tpl">نمایش همه</a></h3>
                        <div class="category-module-content">
                            <ul id="sub-cat" class="tabs">
                                <li><a href="#tab-cat1">لپ تاپ</a></li>
                                <li><a href="#tab-cat2">رومیزی</a></li>
                                <li><a href="#tab-cat3">دوربین</a></li>
                                <li><a href="#tab-cat4">موبایل و تبلت</a></li>
                                <li><a href="#tab-cat5">صوتی و تصویری</a></li>
                                <li><a href="#tab-cat6">لوازم خانگی</a></li>
                            </ul>
                            <div id="tab-cat1" class="tab_content">
                                <div class="owl-carousel latest_category_tabs">
                                    <div class="product-thumb">
                                        <div class="image"><a href="product.html"><img
                                                        src="{{ asset('market/image/product/iphone_6-200x200.jpg')}}"
                                                        alt="کرم مو آقایان" title="کرم مو آقایان"
                                                        class="img-responsive"/></a></div>
                                        <div class="caption">
                                            <h4><a href="product.html">کرم مو آقایان</a></h4>
                                            <p class="price"> 42300 تومان </p>
                                        </div>
                                        <div class="button-group">
                                            <button class="btn-primary" type="button" onClick="">
                                                <span>افزودن به سبد</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ها محصولات Slider End-->
                    <!-- Banner Start -->
                    <div class="marketshop-banner">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a href="#"><img
                                            src="{{ asset('market/image/banner/sample-banner-4-400x150.jpg')}}"
                                            alt="2 Block Banner"
                                            title="2 Block Banner"/></a></div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a href="#"><img
                                            src="{{ asset('market/image/banner/sample-banner-5-400x150.jpg')}}"
                                            alt="2 Block Banner 1"
                                            title="2 Block Banner 1"/></a></div>
                        </div>
                    </div>
                    <!-- Banner End -->
                    <!-- دسته ها محصولات Slider Start -->
                    <h3 class="subtitle">زیبایی و سلامت - <a class="viewall" href="category.html">نمایش همه</a></h3>
                    <div class="owl-carousel latest_category_carousel">
                        <div class="product-thumb">
                            <div class="image"><a href="product.html"><img
                                            src="{{ asset('market/image/product/iphone_6-200x200.jpg')}}"
                                            alt="کرم مو آقایان" title="کرم مو آقایان"
                                            class="img-responsive"/></a></div>
                            <div class="caption">
                                <h4><a href="product.html">کرم مو آقایان</a></h4>
                                <p class="price"> 42300 تومان </p>
                            </div>
                            <div class="button-group">
                                <button class="btn-primary" type="button" onClick=""><span>افزودن به سبد</span></button>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ها محصولات Slider End -->
                    <!-- Brand محصولات Slider Start-->
                    <h3 class="subtitle">اپل - <a class="viewall" href="category.html">نمایش همه</a></h3>
                    <div class="owl-carousel latest_brands_carousel">
                        <div class="product-thumb">
                            <div class="image"><a href="product.html"><img
                                            src="{{ asset('market/image/product/iphone_6-200x200.jpg')}}"
                                            alt="کرم مو آقایان" title="کرم مو آقایان"
                                            class="img-responsive"/></a></div>
                            <div class="caption">
                                <h4><a href="product.html">کرم مو آقایان</a></h4>
                                <p class="price"> 42300 تومان </p>
                            </div>
                            <div class="button-group">
                                <button class="btn-primary" type="button" onClick=""><span>افزودن به سبد</span></button>
                            </div>
                        </div>
                    </div>
                    <!-- Brand محصولات Slider End -->
                </div>
                <!--Middle Part End-->
            </div>
        </div>
    </div>
    <!--Footer Start-->
    <footer id="footer">
        <div class="fpart-first">
            <div class="container">
                <div class="row">
                    <div class="contact col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <h5>اطلاعات تماس</h5>
                        <ul>
                            <li class="address"><i class="fa fa-map-marker"></i>میدان تایمز، شماره 77، نیویورک</li>
                            <li class="mobile"><i class="fa fa-phone"></i>+21 9898777656</li>
                            <li class="email"><i class="fa fa-envelope"></i>برقراری ارتباط از طریق <a
                                        href="contact-us.html">تماس با ما</a>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>اطلاعات</h5>
                        <ul>
                            <li><a href="about-us.html">درباره ما</a></li>
                            <li><a href="about-us.html">اطلاعات ارسال</a></li>
                            <li><a href="about-us.html">حریم خصوصی</a></li>
                            <li><a href="about-us.html">شرایط و قوانین</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>خدمات مشتریان</h5>
                        <ul>
                            <li><a href="contact-us.html">تماس با ما</a></li>
                            <li><a href="#">بازگشت</a></li>
                            <li><a href="sitemap.html">نقشه سایت</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>امکانات جانبی</h5>
                        <ul>
                            <li><a href="#">برند ها</a></li>
                            <li><a href="#">کارت هدیه</a></li>
                            <li><a href="#">بازاریابی</a></li>
                            <li><a href="#">ویژه ها</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>حساب من</h5>
                        <ul>
                            <li><a href="#">حساب کاربری</a></li>
                            <li><a href="#">تاریخچه سفارشات</a></li>
                            <li><a href="#">لیست علاقه مندی</a></li>
                            <li><a href="#">خبرنامه</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="fpart-second">
            <div class="container">
                <div id="powered" class="clearfix">
                    <div class="powered_text pull-left flip">
                        <p>کپی رایت © 2016
                        </p>
                    </div>
                    <div class="social pull-right flip"><a href="#" target="_blank"> <img data-toggle="tooltip"
                                                                                          src="{{ asset('market/image/socialicons/facebook.png')}}"
                                                                                          alt="Facebook"
                                                                                          title="Facebook"></a> <a
                                href="#" target="_blank"> <img data-toggle="tooltip"
                                                               src="{{ asset('market/image/socialicons/twitter.png')}}"
                                                               alt="Twitter" title="Twitter"> </a> <a href="#"
                                                                                                      target="_blank">
                            <img data-toggle="tooltip" src="{{ asset('market/image/socialicons/google_plus.png')}}"
                                 alt="Google+"
                                 title="Google+"> </a> <a href="#" target="_blank"> <img data-toggle="tooltip"
                                                                                         src="{{ asset('market/image/socialicons/pinterest.png')}}"
                                                                                         alt="Pinterest"
                                                                                         title="Pinterest"> </a> <a
                                href="#" target="_blank"> <img data-toggle="tooltip"
                                                               src="{{ asset('market/image/socialicons/rss.png')}}"
                                                               alt="RSS" title="RSS"> </a></div>
                </div>
                <div class="bottom-row">
                    <div class="custom-text text-center">
                        <p>design by</p>
                    </div>
                </div>
            </div>
            <div id="back-top"><a data-toggle="tooltip" title="بازگشت به بالا" href="javascript:void(0)"
                                  class="backtotop"><i class="fa fa-chevron-up"></i></a></div>
    </footer>
    <!--Footer End-->
</div>
<!-- JS Part Start-->
<script type="text/javascript" src="{{ asset('market/js/jquery-2.1.1.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('market/js/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('market/js/jquery.easing-1.3.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('market/js/jquery.dcjqaccordion.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('market/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('market/js/custom.js')}}"></script>
<!-- JS Part End-->
</body>
</html>
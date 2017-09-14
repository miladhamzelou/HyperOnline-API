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
                                <li><a href="{{ url('checkout') }}">تسویه حساب</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="top-links" class="nav pull-right flip">
                        <ul>
                            @if(Auth::check())
                                @if($admin)
                                    <li><a href="{{ url('admin') }}" target="_blank">پنل ادمین</a></li>
                                @endif
                                <li><a href="{{ url('profile') }}" target="_blank">پروفایل</a></li>
                            @else
                                <li><a href="{{ url('login') }}">ورود</a></li>
                                <li><a href="{{ url('register') }}">ثبت نام</a></li>
                            @endif
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
                        <div id="logo"><a href="{{ url('') }}"><img class="img-responsive"
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
                                <span id="cart-total">{{ $cart['count'].' کالا - '.$cart['total'].' تومان' }}</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <table class="table">
                                        <tbody>
                                        @foreach($cart['items'] as $item)
                                            <tr>
                                                <td class="text-center"><a href="product.html"><img
                                                                class="img-thumbnail"
                                                                title="کفش راحتی مردانه"
                                                                alt="کفش راحتی مردانه"
                                                                src="{{ asset('market/image/product/sony_vaio_1-50x50.jpg')}}"></a>
                                                </td>
                                                <td class="text-left"><a href="product.html">{{ $item->name }}</a></td>
                                                <td class="text-right">{{ 'x ' . $item->qty }}</td>
                                                <td class="text-right">{{ $item->subtotal . ' تومان' }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-xs remove" title="حذف" onClick=""
                                                            type="button"><i class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </li>
                                <li>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <td class="text-right"><strong>جمع کل</strong></td>
                                                <td class="text-right">{{ $cart['subtotal'] . ' تومان' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>مالیات</strong></td>
                                                <td class="text-right">{{ $cart['tax'] . ' تومان' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right"><strong>قابل پرداخت</strong></td>
                                                <td class="text-right">{{ $cart['total'] . ' تومان' }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p class="checkout"><a href="cart" class="btn btn-primary"><i
                                                        class="fa fa-shopping-cart"></i> مشاهده سبد</a>&nbsp;&nbsp;&nbsp;<a
                                                    href="{{ url('checkout') }}" class="btn btn-primary"><i
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
        <!-- Main Start-->
        <div class="container">
            <nav id="menu" class="navbar">
                <div class="navbar-header"><span class="visible-xs visible-sm"> منو <b></b></span></div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li><a class="home_link" title="خانه" href="{{ url('') }}"><span>خانه</span></a></li>
                        <li class="mega-menu dropdown"><a>دسته ها</a>
                            <div class="dropdown-menu">
                                @foreach($categories as $c1)
                                    @if($c1['level']==1)
                                        <div class="column col-lg-2 col-md-3"><a
                                                    href="{{ url('category/1/'. $c1['unique_id']) }}">{{ $c1['name'] }}</a>
                                            <div>
                                                <ul>
                                                    @foreach($categories as $c2)
                                                        @if($c2['level']==2 && $c2['parent_id']==$c1['unique_id'])
                                                            <li>
                                                                <a href="{{ url('category/2/'. $c2['unique_id']) }}">{{ $c2['name'] }}
                                                                    <span>&rsaquo;</span></a>
                                                                <div class="dropdown-menu">
                                                                    <ul>
                                                                        @foreach($categories as $c3)
                                                                            @if($c3['level']==3 && $c3['parent_id']==$c2['unique_id'])
                                                                                <li>
                                                                                    <a href="{{ url('category/3/'. $c3['unique_id']) }}">{{ $c3['name'] }}</a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            {{--@else
                                                                <li><a href="{{ url('category/'. $c2['unique_id']) }}">{{ $c2['name'] }}</a></li>--}}
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </li>


                        <li class="contact-link"><a href="{{ url('contact-us') }}">تماس با ما</a></li>
                        <li class="custom-link-right"><a href="{{ url('off') }}" target="_blank">تخفیف خورده ها !!</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Main آقایانu End-->
    </div>
    <div id="container">
        <!-- Feature Box Start-->
            @yield('feature-box')
        <!-- Feature Box End-->
        <div class="container">
            <div class="row">
                <!-- Left Part Start-->
            @yield('right-panel')
            <!-- Left Part End-->
                <!--Middle Part Start-->

                    @yield('content')

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
                            <li class="address"><i class="fa fa-map-marker"></i>همدان / خیابان مهدیه</li>
                            <li class="mobile"><i class="fa fa-phone"></i>081−38263324</li>
                            <li class="email"><i class="fa fa-envelope"></i>برقراری ارتباط از طریق <a
                                        href="{{ url('/contact-us') }}">تماس با ما</a>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>اطلاعات</h5>
                        <ul>
                            <li><a href="{{ url('/about') }}">درباره ما</a></li>
                            <li><a href="{{ url('/privacy') }}">حریم خصوصی</a></li>
                            <li><a href="{{ url('/terms') }}">شرایط و قوانین</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>خدمات مشتریان</h5>
                        <ul>
                            <li><a href="{{ url('/contact-us') }}">تماس با ما</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>امکانات جانبی</h5>
                        <ul>
                            <li><a href="{{ url('/off') }}">تخفیف خورده ها</a></li>
                        </ul>
                    </div>
                    <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                        <h5>حساب من</h5>
                        <ul>
                            <li><a href="{{ url('/profile') }}">حساب کاربری</a></li>
                            <li><a href="{{ url('/orders') }}">تاریخچه سفارشات</a></li>
                            <li><a href="{{ url('/feed') }}">خبرنامه</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="fpart-second">
            <div class="container">
                <div id="powered" class="clearfix">
                    <div class="powered_text pull-left flip">
                        <p>کپی رایت © {{ date("Y") }} − کلیه ی حقوق مادی و معنوی این سایت مربوط به هایپرآنلاین می
                            باشد</p>
                    </div>
                    <div class="social pull-right flip"><a href="{{ $social['facebook'] }}" target="_blank"> <img
                                    data-toggle="tooltip"
                                    src="{{ asset('market/image/socialicons/facebook.png')}}"
                                    alt="Facebook"
                                    title="Facebook"></a> <a
                                href="{{ $social['twitter'] }}" target="_blank"> <img data-toggle="tooltip"
                                                                                      src="{{ asset('market/image/socialicons/twitter.png')}}"
                                                                                      alt="Twitter" title="Twitter">
                        </a> <a href="{{ $social['google'] }}"
                                target="_blank">
                            <img data-toggle="tooltip" src="{{ asset('market/image/socialicons/google_plus.png')}}"
                                 alt="Google+"
                                 title="Google+"> </a> <a href="{{ $social['pinterest'] }}" target="_blank"> <img
                                    data-toggle="tooltip"
                                    src="{{ asset('market/image/socialicons/pinterest.png')}}"
                                    alt="Pinterest"
                                    title="Pinterest"> </a> <a
                                href="{{ url('feed') }}" target="_blank"> <img data-toggle="tooltip"
                                                                               src="{{ asset('market/image/socialicons/rss.png')}}"
                                                                               alt="RSS" title="RSS"> </a></div>
                </div>
                <div class="bottom-row">
                    <div class="custom-text text-center">
                        {{--<p>طراحی شده توسط : آرش حاتمی</p>--}}
                    </div>
                </div>
            </div>
            <div id="back-top"><a data-toggle="tooltip" title="بازگشت به بالا" href="javascript:void(0)"
                                  class="backtotop"><i class="fa fa-chevron-up"></i></a></div>
        </div>
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
<script type="text/javascript" src="{{ asset('js/mine.js')}}"></script>
<!-- JS Part End-->
</body>
</html>
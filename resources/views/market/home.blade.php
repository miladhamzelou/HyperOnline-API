@extends('market.layout.base')



@section('feature-box')
    <div class="container">
        <div class="custom-feature-box row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="feature-box fbox_1">
                    <div class="title">ارسال رایگان</div>
                    <p>برای خرید های بیش از 35 هزار تومان</p>
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
@endsection




@section('right-panel')
    <aside id="column-left" class="col-sm-3 hidden-xs">
        <h3 class="subtitle">دسته ها</h3>
        <div class="box-category">
            <ul id="cat_accordion">
                @foreach($categories as $c1)
                    @if($c1['level']==1)
                        <li><a href="category.html">{{ $c1['name'] }}</a>
                            <span class="down"></span>
                            <ul>
                                @foreach($categories as $c2)
                                    @if($c2['level']==2 && $c2['parent_id']==$c1['unique_id'])
                                        <li><a href="category.html">{{ $c2['name'] }}</a>
                                            <span class="down"></span>
                                            <ul>
                                                @foreach($categories as $c3)
                                                    @if($c3['level']==3 && $c3['parent_id']==$c2['unique_id'])
                                                        <li><a href="category.html">{{ $c3['name'] }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
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
                    <p class="price"><span class="price-new">110000 تومان</span> <span
                                class="price-old">122000 تومان</span>
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
@endsection
<!-- Left Part End-->
<!--Middle Part Start-->
@section('content')
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
        <h3 class="subtitle">دسته بندی تصادفی - <a class="viewall" href="category.html">نمایش همه</a></h3>
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
        <h3 class="subtitle">دسته بندی تصادفی - <a class="viewall" href="category.html">نمایش همه</a></h3>
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
@endsection
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
        <a href="#">
            <img src="{{ asset('market/image/banner/download.jpg') }}" title="download" class="img-responsive"/>
        </a>
        <br>
        <h3 class="subtitle">پرفروش ها</h3>
        <div class="side-item">
            @foreach($most as $m)
                <div class="product-thumb clearfix">
                    <div class="image">
                        <a href="">
                            <img src="{{ asset('market/image/no_image.jpg') }}" class="img-responsive"/>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="">{{ $m['name']  }}</a></h4>
                        <h6 class="description" style="color: grey">{{ $m['description'] }}</h6>
                        @if($m['off']  > 0)
                            <p class="price">
                                <span class="price-new">{{ round($m['price'] - ($m['price']  * $m['off']  / 100)) . ' تومان' }}</span>
                                <span class="price-old">{{ $m['price']  . ' تومان' }}</span>
                                {{--<span class="saving">{{ $m['off']  }}%-</span>--}}
                            </p>
                        @else
                            <p class="price"><span class="price-new">{{ $m['price']  . ' تومان' }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <h3 class="subtitle">جدیدترین</h3>
        <div class="side-item">
            @foreach($new as $product)
                <div class="product-thumb clearfix">
                    <div class="image">
                        <a href="">
                            @if($product['image'])
                                <img src="{{ asset('images').'/' . $product['image'] }}" class="img-responsive"/>
                            @else
                                <img src="{{ asset('market/image/no_image.jpg') }}" class="img-responsive"/>
                            @endif
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="">{{ $product['name'] }}</a></h4>
                        <h6 class="description" style="color: grey">{{ $product['description'] }}</h6>
                        @if($product['off'] > 0)
                            <p class="price">
                                <span class="price-new">{{ round($product['price'] - ($product['price'] * $product['off'] / 100)) . ' تومان' }}</span>
                                <span class="price-old">{{ $product['price'] . ' تومان' }}</span>
                                {{--<span class="saving">{{ $product['off'] }}%-</span>--}}
                            </p>
                        @else
                            <p class="price"><span class="price-new">{{ $product['price'] . ' تومان' }}</span>
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
        @if(count($off))
            <h3 class="subtitle">ویژه</h3>
            <div class="owl-carousel product_carousel">
                @foreach($off as $product)
                    <div class="product-thumb clearfix">
                        <input type="hidden" id="{{ $product['unique_id'] }}" value="{{ $product['unique_id'] }}">
                        <div class="image">
                            <a href="">
                                @if($product['image'])
                                    <img src="{{ asset('images').'/' . $product['image'] }}" class="img-responsive"/>
                                @else
                                    <img src="{{ asset('market/image/no_image.jpg') }}" class="img-responsive"/>
                                @endif
                            </a>
                        </div>
                        <div class="caption">
                            <h4><a href="">{{ $product['name'] }}</a></h4>
                            <h6 class="description" style="color: grey">{{ $product['description'] }}</h6>
                            <p class="price">
                                <span class="price-new">{{ round($product['price'] - ($product['price'] * $product['off'] / 100)) . ' تومان' }}</span>
                                <br>
                                <span class="price-old">{{ $product['price'] . ' تومان' }}</span>
                                {{--<span class="saving">{{ $product['off'] }}%-</span>--}}
                            </p>
                        </div>
                        <div class="button-group">
                            <a href="javascript:void(0);"
                               onClick="addCart(document.getElementById('{{ $product['unique_id'] }}').value)">
                                <button class="btn-primary" type="button">
                                    <span>افزودن به سبد</span>
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
    @endif
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
            <h3 class="subtitle">{{ $rand3['name'] }} - <a class="viewall"
                                                           href="{{ url('category/2/'. $rand3['id']) }}">نمایش همه</a>
            </h3>
            <div class="category-module-content">
                <ul id="sub-cat" class="tabs">
                    @foreach($rand3['subs'] as $cat)
                        <li><a href="#{{ $cat['unique_id'] }}">{{ $cat['name'] }}</a></li>
                    @endforeach
                </ul>
                @foreach($rand3['subs'] as $cat)
                    <div id="{{ $cat['unique_id'] }}" class="tab_content">
                        <div class="owl-carousel latest_category_tabs">
                            @foreach($rand3['products'] as $product)
                                {{--@if($product['category_id'] == $cat['unique_id'])--}}
                                <div class="product-thumb">
                                    <input type="hidden" id="{{ $product['unique_id'] }}"
                                           value="{{ $product['unique_id'] }}">
                                    <div class="image">
                                        <a href="">
                                            @if($product['image'])
                                                <img src="{{ asset('images').'/' . $product['image'] }}"
                                                     class="img-responsive"/>
                                            @else
                                                <img src="{{ asset('market/image/no_image.jpg') }}"
                                                     class="img-responsive"/>
                                            @endif
                                        </a>
                                    </div>
                                    <div>
                                        <div class="caption">
                                            <h4><a href="">{{ $product['name'] }}</a></h4>
                                            <h6 class="description" style="color: grey">{{ $product['description'] }}</h6>
                                            @if($product['off'] > 0)
                                                <p class="price">
                                                    <span class="price-new">{{ round($product['price'] - ($product['price'] * $product['off'] / 100)) . ' تومان' }}</span>
                                                    <br>
                                                    <span class="price-old">{{ $product['price'] . ' تومان' }}</span>
                                                    {{--<span class="saving">{{ $product['off'] }}%-</span>--}}
                                                </p>
                                            @else
                                                <p class="price">
                                                    <span class="price-new">{{ $product['price'] . ' تومان' }}</span>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="button-group">
                                            <a href="javascript:void(0);"
                                               onClick="addCart(document.getElementById('{{ $product['unique_id'] }}').value)">
                                                <button class="btn-primary" type="button">
                                                    <span>افزودن به سبد</span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{--@endif--}}
                            @endforeach
                        </div>
                    </div>
                @endforeach
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
        <h3 class="subtitle">{{ $rand1['name'] }} - <a class="viewall" href="{{ url('category/3/'. $rand1['id']) }}">نمایش
                همه</a></h3>
        <div class="owl-carousel latest_category_carousel">
            @foreach($rand1['products'] as $product)
                <div class="product-thumb">
                    <input type="hidden" id="{{ $product['unique_id'] }}" value="{{ $product['unique_id'] }}">
                    <div class="image">
                        <a href="">
                            @if($product['image'])
                                <img src="{{ asset('images').'/' . $product['image'] }}"
                                     class="img-responsive"/>
                            @else
                                <img src="{{ asset('market/image/no_image.jpg') }}"
                                     class="img-responsive"/>
                            @endif
                        </a>
                    </div>
                    <div>
                        <div class="caption">
                            <h4><a href="">{{ $product['name'] }}</a></h4>
                            <h6 class="description" style="color: grey">{{ $product['description'] }}</h6>
                            @if($product['off'] > 0)
                                <p class="price">
                                    <span class="price-new">{{ round($product['price'] - ($product['price'] * $product['off'] / 100)) . ' تومان' }}</span>
                                    <br>
                                    <span class="price-old">{{ $product['price'] . ' تومان' }}</span>
                                    {{--<span class="saving">{{ $product['off'] }}%-</span>--}}
                                </p>
                            @else
                                <p class="price"><span
                                            class="price-new">{{ $product['price'] . ' تومان' }}</span>
                                </p>
                            @endif
                        </div>
                        <div class="button-group">
                            <a href="javascript:void(0);"
                               onClick="addCart(document.getElementById('{{ $product['unique_id'] }}').value)">
                                <button class="btn-primary" type="button">
                                    <span>افزودن به سبد</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- دسته ها محصولات Slider End -->
        <!-- Brand محصولات Slider Start-->
        <h3 class="subtitle">{{ $rand2['name'] }} - <a class="viewall" href="{{ url('category/3/'. $rand2['id']) }}">نمایش
                همه</a></h3>
        <div class="owl-carousel latest_category_carousel">
            @foreach($rand2['products'] as $product)
                <div class="product-thumb">
                    <input type="hidden" id="{{ $product['unique_id'] }}" value="{{ $product['unique_id'] }}">
                    <div class="image">
                        <a href="">
                            @if($product['image'])
                                <img src="{{ asset('images').'/' . $product['image'] }}"
                                     class="img-responsive"/>
                            @else
                                <img src="{{ asset('market/image/no_image.jpg') }}"
                                     class="img-responsive"/>
                            @endif
                        </a>
                    </div>
                    <div>
                        <div class="caption">
                            <h4><a href="">{{ $product['name'] }}</a></h4>
                            <h6 class="description" style="color: grey">{{ $product['description'] }}</h6>
                            @if($product['off'] > 0)
                                <p class="price">
                                    <span class="price-new">{{ round($product['price'] - ($product['price'] * $product['off'] / 100)) . ' تومان' }}</span>
                                    <br>
                                    <span class="price-old">{{ $product['price'] . ' تومان' }}</span>
                                    {{--<span class="saving">{{ $product['off'] }}%-</span>--}}
                                </p>
                            @else
                                <p class="price"><span class="price-new">{{ $product['price'] . ' تومان' }}</span>
                                </p>
                            @endif
                        </div>
                        <div class="button-group">
                            <a href="javascript:void(0);"
                               onClick="addCart(document.getElementById('{{ $product['unique_id'] }}').value)">
                                <button class="btn-primary" type="button">
                                    <span>افزودن به سبد</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Brand محصولات Slider End -->
    </div>
@endsection
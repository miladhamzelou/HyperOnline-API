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
                        <li><a href="{{ url('category/1/'. $c1['unique_id']) }}">{{ $c1['name'] }}</a>
                            <span class="down"></span>
                            <ul>
                                @foreach($categories as $c2)
                                    @if($c2['level']==2 && $c2['parent_id']==$c1['unique_id'])
                                        <li><a href="{{ url('category/2/'. $c2['unique_id']) }}">{{ $c2['name'] }}</a>
                                            <span class="down"></span>
                                            <ul>
                                                @foreach($categories as $c3)
                                                    @if($c3['level']==3 && $c3['parent_id']==$c2['unique_id'])
                                                        <li>
                                                            <a href="{{ url('category/3/'. $c3['unique_id']) }}">{{ $c3['name'] }}</a>
                                                        </li>
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
            @foreach($most as $m)
                <div class="product-thumb clearfix">
                    <div class="image">
                        <a href="">
                            <img src="{{ asset('market/image/no_image.jpg') }}"
                                 class="img-responsive"/>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="">{{ $m['name']  }}</a></h4>
                        <h6 class="description" style="color: grey">{{ $m['description'] }}</h6>
                        @if($m['off']  > 0)
                            <p class="price"><span
                                        class="price-new">{{ round($m['price'] - ($m['price']  * $m['off']  / 100)) . ' تومان' }}</span>
                                <span class="price-old">{{ $m['price']  . ' تومان' }}</span>
                                <span class="saving">{{ $m['off']  }}%-</span>
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
                                <img src="{{ asset('images').'/' . $product['image'] }}"
                                     class="img-responsive"/>                            @else
                                <img src="{{ asset('market/image/no_image.jpg') }}" class="img-responsive"/>
                            @endif
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="">{{ $product['name'] }}</a></h4>
                        <h6 class="description" style="color: grey">{{ $product['description'] }}</h6>
                        @if($product['off'] > 0)
                            <p class="price"><span
                                        class="price-new">{{ round($product['price'] - ($product['price'] * $product['off'] / 100)) . ' تومان' }}</span>
                                <span class="price-old">{{ $product['price'] . ' تومان' }}</span>
                                <span class="saving">{{ $product['off'] }}%-</span>
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

@section('content')
    <div id="content" class="col-sm-9">
        <h1 class="title">{{ $name }}</h1>
        @if($level != 3)
            <div class="category-list-thumb row">
                @foreach($sub as $category)
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                        <a href="{{ url('category/'. ($level+1) .'/'. $category['unique_id']) }}">
                            @if($category['image'])
                                <img src="{{ asset('images').'/' . $category['image'] }}"
                                     class="img-responsive"/>
                            @else
                                <img src="{{ asset('market/image/no_image.jpg') }}"
                                     class="img-responsive"/>
                            @endif
                        </a>
                        <a href="{{ url('category/'. ($level+1) .'/'. $category['unique_id']) }}">{{ $category['name'] }}</a>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="product-filter">
            <div class="row">
                <div class="col-md-4 col-sm-5">
                    <div class="btn-group">
                        <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="List">
                            <i class="fa fa-th-list"></i></button>
                        <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Grid">
                            <i class="fa fa-th"></i></button>
                    </div>
                    {{--<a href="compare.html" id="compare-total">محصولات مقایسه (0)</a></div>
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-sort">مرتب سازی :</label>
                </div>
                <div class="col-md-3 col-sm-2 text-right">
                    <select id="input-sort" class="form-control col-sm-3">
                        <option value="" selected="selected">پیشفرض</option>
                        <option value="">نام (الف - ی)</option>
                        <option value="">نام (ی - الف)</option>
                        <option value="">قیمت (کم به زیاد)</option>
                        <option value="">قیمت (زیاد به کم)</option>
                        <option value="">امتیاز (بیشترین)</option>
                        <option value="">امتیاز (کمترین)</option>
                        <option value="">مدل (A - Z)</option>
                        <option value="">مدل (Z - A)</option>
                    </select>
                </div>
                <div class="col-sm-1 text-right">
                    <label class="control-label" for="input-limit">نمایش :</label>
                </div>
                <div class="col-sm-2 text-right">
                    <select id="input-limit" class="form-control">
                        <option value="" selected="selected">20</option>
                        <option value="">25</option>
                        <option value="">50</option>
                        <option value="">75</option>
                        <option value="">100</option>
                    </select>
                </div>--}}
                </div>
            </div>
        </div>
        <br/>
        <div class="row products-category">
            @if(!count($products))
                <p>محصولی در این دسته بندی وجود ندارد</p>
            @else
                @foreach($products as $product)
                    <input type="hidden" id="uid" value="{{ $product['unique_id'] }}">
                    <div class="product-layout product-list col-xs-12">
                        <div class="product-thumb">
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
                                       onClick="addCart(document.getElementById('uid').value)">
                                        <button class="btn-primary" type="button">
                                            <span>افزودن به سبد</span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
@endsection
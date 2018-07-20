@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('description')
    {{ $description }}
@endsection

@section('info-box')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-red">
                            <i class="icon ion ion-ios-pricetags-outline"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">دسته بندی ها</span>
                    <span class="info-box-number">{{ $category_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-green">
                            <i class="icon ion-pizza"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">محصولات</span>
                    <span class="info-box-number">{{ $product_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="icon ion-ios-cart"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">سفارشات</span>
                    <span class="info-box-number">{{ $order_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="icon ion-ios-people"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">کاربران</span>
                    <span class="info-box-number">{{ $user_count }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('order-chart')
    <div class="box box-info">
        <div class="box-header with-border">
            <h2 class="box-title">گزارشات سفارش ها</h2>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            {!! $priceChart->render() !!}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        {!! $countChart->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('reports')
    <div class="row">
        <div class="col-lg-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h2 class="box-title">جدیدترین مشتری ها</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th style="text-align: right; direction: rtl;">آدرس</th>
                                    <th style="text-align: right; direction: rtl;">شماره تماس</th>
                                    <th style="text-align: right; direction: rtl;">نام</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->address }}</td>
                                        <td style="text-align: right; direction: rtl;">{{ $user->phone }}</td>
                                        <td style="text-align: right; direction: rtl;"><a
                                                    href="{{ url('/management/users/'.$user->unique_id) }}">{{ $user->name }}</a>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ url('/management/users') }}">لیست کامل</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title">آخرین سفارشات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th style="text-align: right; direction: rtl;">قیمت</th>
                                    <th style="text-align: right; direction: rtl;">محصولات</th>
                                    <th style="text-align: right; direction: rtl;">نام مشتری</th>
                                    <th style="text-align: right; direction: rtl;">کد سفارش</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $order->price }} تومان</td>
                                        <td style="text-align: right; direction: rtl;">{{ $order->stuffs }}</td>
                                        <td style="text-align: right; direction: rtl;">
                                            <a href="{{ url('/management/users/'.$order->user_id) }}">
                                                {{ $order->user_name }}
                                            </a>
                                        </td>
                                        <td style="text-align: right; direction: rtl;">
                                            <a href="{{ url('/management/orders/'.$order->unique_id) }}">
                                                {{ $order->code }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ url('/management/orders') }}">لیست کامل</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">جدیدترین محصولات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$products->count())
                            <p>There is no products</p>
                        @else
                            <ul class="products-list products-list-in-box">
                                @foreach($products as $product)
                                    <li class="item">
                                        <div class="product-img">
                                            @if(!$product->image)
                                                <img src="{{ asset('dist/img/default-50x50.gif') }}"
                                                     alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('images/' . $product->image) }}"
                                                     alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ url('/management/products/'.$product->unique_id) }}"
                                               class="product-title">
                                                {{ $product->name }}
                                                <span class="label label-info pull-right"
                                                      style="font-weight:normal; font-size:12px; direction: rtl;">
                                                    {{ $product->price }} تومان</span>
                                                <br>
                                                <br>
                                                <span class="label label-danger pull-right"
                                                      style="font-weight:normal; font-size:12px; direction: rtl">
                                                    تعداد : {{ $product->count }}</span>
                                            </a>
                                            @if($product->description!="null")
                                                <span class="product-description" style="direction: rtl">
                                            {{ $product->description }}
                                        </span>
                                            @endif
                                        </div>
                                    </li>
                                    <br>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ url('/management/products') }}">لیست کامل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
@endsection
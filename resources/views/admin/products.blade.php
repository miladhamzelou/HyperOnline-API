@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    @if($inactive>0)
        <div class="row">
            <div class="col-lg-4 col-centered center-block" style="float: none;">
                <div class="flash alert-warning">
                    <p class="panel-body" style="font-size:20px; text-align:center; direction: rtl;">
                        <a href="{{ url('/admin/products_inactive') }}" style="color:white;">
                            محصولات تایید نشده ای وجود دارند
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <br>
    @endif
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">لیست محصولات ( به ترتیب تاریخ )</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$products->count())
                            <br>
                            <p style="text-align: center; direction: rtl;">محصولی یافت نشد</p>
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
                                            <a href="{{ url('/admin/products/'.$product->unique_id) }}"
                                               class="product-title">
                                                {{ $product->name }}
                                                <span class="label label-info pull-right"
                                                      style="font-weight:normal; font-size:15px; direction: rtl">
                                                    {{ $product->price }} تومان</span>
                                                <br>
                                                <span class="label label-danger pull-right"
                                                      style="font-weight:normal; font-size:15px; direction: rtl">
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
                </div>
            </div>
        </div>
    </div>
@endsection
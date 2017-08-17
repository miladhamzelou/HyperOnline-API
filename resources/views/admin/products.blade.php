@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Last Products</h2>
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
                                            <a href="{{ url('/admin/products/'.$product->unique_id) }}"
                                               class="product-title">
                                                {{ $product->name }}
                                                <span class="label label-info pull-right" style="font-weight:normal; font-size:15px; direction: rtl">
                                                    {{ $product->price }} تومان</span>
                                                <br>
                                                <span class="label label-danger pull-right" style="font-weight:normal; font-size:15px; direction: rtl">
                                                    تعداد : {{ $product->count }}</span>
                                            </a>
                                            @if($product->description!="null")
                                                <span class="product-description">
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
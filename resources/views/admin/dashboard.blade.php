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
                            <i class="icon fa fa-sitemap"></i>
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
                            <i class="icon fa fa-shopping-basket"></i>
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
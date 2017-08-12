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

@section('chart')
    <div class="row">
        <div class="col-lg-8 col-centered center-block" style="float: none;">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h2 class="box-title">New Product</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <div>
                            {!! $chart->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
@endsection
@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('info-box')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-green">
                            <i class="icon ion-pizza"></i>
                        </span>
                <div class="info-box-content" style="text-align: center; direction: rtl">
                    <span class="info-box-text">تعداد محصولات فروخته شده</span>
                    <span class="info-box-number">{{ $count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="icon ion-social-euro"></i>
                        </span>
                <div class="info-box-content" style="text-align: center; direction: rtl">
                    <span class="info-box-text">کل هزینه های جانبی</span>
                    <span class="info-box-number">{{ $prices['TotalSend'] . ' تومان' }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="icon ion-social-euro"></i>
                        </span>
                <div class="info-box-content" style="text-align: center; direction: rtl">
                    <span class="info-box-text">کل سود تا این لحظه</span>
                    <span class="info-box-number">{{ $prices['TotalBenefit'] . ' تومان' }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="icon ion-social-euro"></i>
                        </span>
                <div class="info-box-content" style="text-align: center; direction: rtl">
                    <span class="info-box-text">کل فروش تا این لحظه</span>
                    <span class="info-box-number">{{ $prices['TotalPrice'] . ' تومان' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="icon ion-ios-cart"></i>
                        </span>
                <div class="info-box-content" style="text-align: center; direction: rtl">
                    <span class="info-box-text">تعداد کل سفارشات</span>
                    <span class="info-box-number">{{ $status['total'] }}</span>
                    <br>
                    <span class="info-box-text">سفارشات در حال انتظار</span>
                    <span class="info-box-number">{{ $status['pending'] }}</span>
                    <br>
                    <span class="info-box-text">سفارشات ارسال شده</span>
                    <span class="info-box-number">{{ $status['shipped'] }}</span>
                    <br>
                    <span class="info-box-text">سفارشات تحویل داده شده</span>
                    <span class="info-box-number">{{ $status['delivered'] }}</span>
                    <br>
                    <span class="info-box-text">سفارشات لغو شده</span>
                    <span class="info-box-number">{{ $status['abort'] }}</span>
                </div>
            </div>
        </div>


    </div>
@endsection
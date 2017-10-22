@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-7 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">اطلاعات سفارش</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">کد سفارش
                                : </strong>{{ $order->code }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">فروشنده
                                : </strong>{{ $order->seller_name }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">نام
                                مشتری : </strong>{{ $order->user_name }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">تلفن
                                مشتری : </strong>{{ $order->user_phone }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">آدرس
                                مشتری : </strong>{{ $address }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">کالا
                                ها : </strong>{{ $order->stuffs }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">قیمت
                                : </strong>{{ $order->price . ' تومان' }}</p><br>
                        @if($order->hour==18)
                            <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">ساعت
                                    تحویل : </strong> الی </p><br>
                        @else
                            <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">ساعت
                                    تحویل : </strong>{{ $order->hour }}</p><br>
                        @endif
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">روش
                                پرداخت : </strong>{{ $order->pay_method }}</p><br>
                        @if($order->status=="abort")
                            <p style="text-align: justify; direction: rtl; color: red;"><strong
                                        style="color:#3c8dbc; font-size: 19px;">وضعیت فعلی : </strong>لغو شده</p><br>
                        @elseif($order->status=="delivered")
                            <p style="text-align: justify; direction: rtl; color: green;"><strong
                                        style="color:#3c8dbc; font-size: 19px;">وضعیت فعلی : </strong>تحویل شده</p><br>
                        @elseif($order->status=="shipped")
                            <p style="text-align: justify; direction: rtl; color: darkviolet"><strong
                                        style="color:#3c8dbc; font-size: 19px;">وضعیت فعلی : </strong>ارسال شده</p><br>
                        @elseif($order->status=="pending")
                            <p style="text-align: justify; direction: rtl; color: orange"><strong
                                        style="color:#3c8dbc; font-size: 19px;">وضعیت فعلی : </strong>درحال انتظار</p>
                            <br>
                        @endif
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">کد
                                : </strong>{{ $order->code }}</p><br>
                        @if($order->description)
                            <p style="text-align: justify; direction: rtl;"><strong
                                        style="color:#3c8dbc; font-size: 19px;">توضیحات
                                    : </strong>{{ $order->description }}</p><br>
                        @else
                            <p style="text-align: justify; direction: rtl;"><strong
                                        style="color:#3c8dbc; font-size: 19px;">توضیحات
                                    : </strong>ندارد</p><br>
                        @endif
                        <p style="text-align: right; direction: ltr"><strong style="color:#3c8dbc; font-size: 19px;">تاریخ
                                / ساعت : </strong>{{ $order->create_date }}</p><br>
                        <br>
                        <a class="btn btn-success pull-right btn-lg" tabindex="1"
                           href="{{ url('admin/downloadFactor/' . $order->code) }}">دانلود فاکتور</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
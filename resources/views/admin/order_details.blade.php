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
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">فروشنده : </strong>{{ $order->seller_name }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">نام مشتری : </strong>{{ $order->user_name }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">تلفن مشتری : </strong>{{ $order->user_phone }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">کالا ها : </strong>{{ $order->stuffs }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">قیمت : </strong>{{ $order->price }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">ساعت تحویل : </strong>{{ $order->hour }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">روش پرداخت : </strong>{{ $order->pay_method }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">وضعیت فعلی : </strong>{{ $order->status }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">کد : </strong>{{ $order->code }}</p><br>
                        <p style="text-align: justify; direction: rtl;"><strong style="color:#3c8dbc; font-size: 19px;">توضیحات : </strong>{{ $order->description }}</p><br>
                        <p style="text-align: right; direction: ltr"><strong style="color:#3c8dbc; font-size: 19px;">تاریخ / ساعت : </strong>{{ $order->create_date }}</p><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
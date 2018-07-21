@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-12 col-centered center-block" style="float: none;">
            <h3 style="color: red; text-align: center;">سفارشات خاکستری رنگ هنوز پرداخت نشده اند</h3>
            <br>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">لیست سفارشات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!count($orders))
                            <br>
                            <p style="text-align: center">سفارشی ثبت نشده است</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">وضعیت</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">سود</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">قیمت</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">محصولات</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام مشتری</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">کد سفارش</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                            @if($order->temp==0)
                                                <tr>
                                                @if($order->status=="abort")
                                                    <td style="text-align: right; direction: rtl; color: red;">لغو شده</td>
                                                @elseif($order->status=="delivered")
                                                    <td style="text-align: right; direction: rtl; color: green">تحویل شده</td>
                                                @elseif($order->status=="shipped")
                                                    <td style="text-align: right; direction: rtl; color: darkviolet">ارسال شده</td>
                                                @elseif($order->status=="pending")
                                                    <td style="text-align: right; direction: rtl; color: orange">درحال انتظار</td>
                                                @endif
                                            @else
                                                @if($order->pay_method=="place")
                                                    <tr>
                                                    @if($order->status=="abort")
                                                        <td style="text-align: right; direction: rtl; color: red;">لغو شده</td>
                                                    @elseif($order->status=="delivered")
                                                        <td style="text-align: right; direction: rtl; color: green">تحویل شده</td>
                                                    @elseif($order->status=="shipped")
                                                        <td style="text-align: right; direction: rtl; color: darkviolet">ارسال شده</td>
                                                    @elseif($order->status=="pending")
                                                        <td style="text-align: right; direction: rtl; color: orange">درحال انتظار</td>
                                                    @endif
                                                @else
                                                    <tr style="background-color: lightgrey">
                                                    <td style="text-align: right; direction: rtl; color: red;">در انتظار پرداخت</td>
                                                @endif
                                            @endif
                                            <td style="text-align: right; direction: rtl;">{{ (str_replace(',','',$order->price) - str_replace(',','',$order->price_original)) . ' تومان' }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $order->price . ' تومان' }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ str_replace(','," - ",$order->stuffs) }}</td>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/management/users/' . $order->user_id) }}">
                                                    {{ $order->user_name }}
                                                </a>
                                            </td>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/management/orders/' . $order->unique_id) }}">
                                                    {{ $order->code }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
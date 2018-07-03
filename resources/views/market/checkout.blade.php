@extends('market.layout.base')

@section('style')
    <style type="text/css">
        #list table {
            border-collapse: collapse;
            border-spacing: 0;
            border-color: #bbb;
        }

        #list table td {
            font-size: 14px;
            padding: 10px 5px;
            overflow: hidden;
            word-break: normal;
            border: 1px solid #bbb;
            color: #594F4F;
        }

        #list table tbody tr:nth-child(even) {
            background-color: #eee;
        }

        #list table th {
            font-size: 14px;
            font-weight: bold;
            padding: 10px 5px;
            overflow: hidden;
            word-break: normal;
            border: 1px solid #bbb;
            color: #493F3F;
            background-color: #ccc;
        }

        #list table yw4l {
            vertical-align: top
        }
    </style>
@endsection

@section('content')
	<?php
	$i = 1;
	$pay = $cart['total'];
	?>
    <div id="content" class="col-sm-12">
        <h2 class="title">سبد خرید</h2>
        @if(count($cart['items'])>0)
            <div class="table-responsive" id="list">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center yw4l">ردیف</th>
                        <th class="text-center yw4l">نام محصول</th>
                        <th class="text-center yw4l">تعداد</th>
                        <th class="text-center yw4l">قیمت واحد</th>
                        <th class="text-center yw4l">کل</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart['items'] as $item)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td class="text-center">{{ $item->name }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-center">{{ number_format($item->subtotal / $item->qty) . ' تومان' }}</td>
                            <td class="text-center">{{ number_format($item->subtotal) . ' تومان' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <p>
                        <span><a class="fa fa-warning"></a> </span>
                        @if($cart['free-ship'] || $cart['tax']==0)
                            سفارش شما رایگان ارسال خواهد شد.
                        @else
                            سبد های کمتر از ۳۰ هزار تومان با هزینه ارسال خواهند شد.
                        @endif
                    </p>
                </div>
                <div class="col-sm-4">
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-right"><strong>جمع کل</strong></td>
                            <td class="text-right" style="text-align: center">{{ $cart['subtotal'] . ' تومان' }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>ارسال / بسته بندی</strong></td>
                            <td class="text-right" style="text-align: center">
                                @if($cart['tax']!=0)
                                    {{ $cart['tax'] . ' تومان' }}
                                @else
                                    رایگان
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>قابل پرداخت</strong></td>
                            <td class="text-right" style="text-align: center">{{ $pay . ' تومان' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <form action="{{ url('pay_confirm') }}" method="post">
                {{ csrf_field() }}
                <div class="buttons">
                    <div style="text-align: center">
                        <label class="radio-inline">
                            <input type="radio" name="pay_way" value="1" checked>پرداخت آنلاین
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay_way" value="0">پرداخت حضوری
                        </label>
                        <br>
                        <br>
                        <input class="btn btn-primary" type="submit"
                               style="font-size: 18px; border-radius: 20px" value="تکمیل خرید"/>
                    </div>
                </div>
            </form>
        @else
            <h4 style="text-align: center">سبد خرید شما خالی است</h4>
            <div class="buttons">
                <div class="pull-left">
                    <a href="{{ url('home') }}" class="btn btn-default" style="font-size: 18px">ادامه خرید</a>
                </div>
            </div>
        @endif
    </div>
@endsection
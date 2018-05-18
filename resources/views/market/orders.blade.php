@extends('market.layout.base')

@section('style')
@endsection
<style>
    .order {
        width: 75%;
        height: auto;
        border-radius: 0 0 15px 15px;
        left: 50%;
        position: relative;
        transform: translateX(-83%);
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
        border-top: 2px solid #e40571;
        padding: 10px;
    }

    .order-count {
        float: left;
        direction: ltr;
        color: #e40571;
    }

    .order-count:before {
        content: "# ";
    }

    .order-date {

    }

    .order-meta {
        list-style-type: none;
        margin: 10px 0 10px 0;
    }

    .order-title {
        margin-left: 8px;
        margin-right: 10px;
        font-weight: 500;
        display: inline;
        color: #e40571;
    }

    .order-description {
        display: inline;
    }

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
        border: 1px solid rgba(0, 0, 0, 0.03);
        color: #594F4F;
        text-align: center;
    }

    #list table tbody tr:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.01);
    }

    #list table th {
        font-size: 14px;
        font-weight: bold;
        padding: 10px 5px;
        overflow: hidden;
        word-break: normal;
        border: 1px solid rgba(0, 0, 0, 0.03);
        color: #493F3F;
        background-color: rgba(0, 0, 0, 0.03);
        text-align: center;
    }
</style>

@section('content')
    <div id="content" class="col-sm-12">
        <h2 style="text-align: right">لیست سفارشات</h2>
        <br>
        <br>
        @foreach($orders as $order)
            @if ($order->pay_method=='online' && $order->temp==1)
                @continue
            @endif
            @php
                $date = explode(' ', $order->create_date)[0];
                $time = explode(' ', $order->create_date)[1];

                $ids = explode(',', $order->stuffs_id);
                $products = array();
                foreach (explode(',', $order->stuffs) as $stuff) {
                    array_push($products, $stuff);
                }
                $counts = explode(',', $order->stuffs_count);
            @endphp
            <div class="order">
                <p class="order-count">{{ $order->code }}</p>
                <p class="order-date">تاریخ {{ $date }} ساعت {{ $time }}</p>
                <div class="order-meta">
                    <p class="order-title">وضعیت :</p>
                    @if($order->status == 'pending')
                        <p class="order-description" style="color: orange">در حال انتظار</p>
                    @elseif($order->status == 'shipped')
                        <p class="order-description" style="color: blue">ارسال شده</p>
                    @elseif($order->status == 'delivered')
                        <p class="order-description" style="color: green">دریافت شده</p>
                    @endif
                </div>
                <div class="table-responsive" id="list">
                    <table class="table table-bordered">
                        <tr>
                            <th width="10%">ردیف</th>
                            <th width="80%">نام</th>
                            <th width="10%">تعداد</th>
                        </tr>
                        @foreach($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product }}</td>
                                <td>{{ $counts[$index] }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <ul>
                        <li class="order-meta">
                            <p class="order-title">مبلغ :</p>
                            <p class="order-description">{{ $order->price }} تومان</p>
                        </li>
                        <li class="order-meta">
                            <p class="order-title">ساعت ارسال :</p>
                            <p class="order-description">{{ $order->hour }}</p>
                        </li>
                        <li class="order-meta">
                            <p class="order-title">توضیحات :</p>
                            @if($order->description)
                                <p class="order-description">{{ $order->description }}</p>
                            @else
                                <p class="order-description">-</p>
                            @endif
                        </li>
                        <li class="order-meta">
                            <p class="order-title">روش پرداخت :</p>
                            @if($order->pay_method == 'online')
                                <p class="order-description">اینترنتی</p>
                            @else
                                <p class="order-description">حضوری</p>
                            @endif
                        </li>
                        <li class="order-meta">
                            <p class="order-title">شماره تراکنش :</p>
                            @if($order->transId)
                                <p class="order-description">{{ $order->transId }}</p>
                            @else
                                <p class="order-description">-</p>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endsection
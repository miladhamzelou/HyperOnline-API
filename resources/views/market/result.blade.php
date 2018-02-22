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
            text-align: center;
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
            text-align: center;
        }

        #list table yw4l {
            vertical-align: top
        }

        strong {
            color: #e40571;
        }
    </style>
@endsection

@section('content')
    <h5>با تشکر از خرید شما. سفارش ثبت شده و در ساعت تعیین شده برای شما ارسال خواهد شد. اطلاعات خرید شما بدین شرح می
        باشد :</h5>
    <hr>
    <p><strong>تاریخ :</strong> {{ $order->create_date }}</p>
    <p><strong>آقا / خانم :</strong> {{ $data['user_name'] }}</p>
    <p><strong>آدرس :</strong> {{ $data['user_address'] }}</p>
    <hr>
    <p><strong>محصولات :</strong></p>
    <div class="table-responsive" id="list">
        <table class="table table-bordered">
            <tr>
                <th width="10%">ردیف</th>
                <th width="80%">نام</th>
                <th width="10%">تعداد</th>
            </tr>
            @foreach($data['products'] as $index => $product)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $data['counts'][$index] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <p><strong>مبلغ پرداخت شده :</strong> {{ $data['total'] }} تومان</p>
    <p><strong>شماره تراکنش :</strong> {{ $order->transId }}</p>
    <p><strong>توضیحات سفارش :</strong> {{ $order->description }}</p>
    <p><strong>ساعت ارسال :</strong> {{ $data['hour'] }}</p>
    <hr>
    <a class="btn btn-success" href="/factor/{{ $order->code }}" target="_blank">دانلود فاکتور</a>
    <a class="btn btn-default" href="{{ url('/') }}">بازگشت</a>
@endsection
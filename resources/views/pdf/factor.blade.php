<html lang="en-IR">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .mine {
            direction: rtl;
        }

        table {
            text-align: center;
            direction: rtl;
            border-collapse: collapse;
            width: 100%;
        }

        .table2 {
            text-align: center;
            direction: rtl;
            border-collapse: collapse;
            width: 25%;
        }

        th {
            background-color: red;
            color: white;
        }

        td, th {
            border: 1px solid #dddddd;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<p class="mine" style="text-align: center;"><strong>هایپرآنلاین - فاکتور فروش</strong></p>
<p class="mine"><strong>شماره فاکتور : </strong>{{ $code }}</p>
<p class="mine"><strong>تاریخ : </strong>{{ $date }}</p>
<hr>
<p class="mine"><strong>آقای / خانم : </strong>{{ $user_name }}</p>
<p class="mine"><strong>کد مشتری : </strong>{{ $user_code }}</p>
<p class="mine"><strong>آدرس مشتری : </strong>{{ $user_address }}</p>
<table>
    <tr>
        <th>نام</th>
        <th>تعداد</th>
        <th>قیمت روی کالا</th>
        <th>قیمت هایپرآنلاین</th>
        <th>قابل پرداخت</th>
    </tr>
    @foreach($products as $index => $product)
        <tr>
            <td>{{ $product['name'] . ' ( ' . $desc[$index] . ' )' }}</td>
            <td>{{ $counts[$index] }}</td>
            <td>{{ $product['price'] }}</td>
            <td>{{ ($product['price']) - ($product['price'] * $product['off'] / 100) }}</td>
            <td>{{ (($product['price']) - ($product['price'] * $product['off'] / 100)) * $counts[$index] . ' تومان' }}</td>
        </tr>
    @endforeach
</table>
<br>
<table class="table2">
    <tr>
        <td>جمع کل</td>
        <td>{{ $total . ' تومان' }}</td>
    </tr>
    <tr>
        <td>سود شما از این خرید</td>
        <td>{{ $off . ' تومان' }}</td>
    </tr>
    <tr>
        <td>هزینه ارسال و بسته بندی</td>
        <td>{{ $send_price . ' تومان' }}</td>
    </tr>
    <tr>
        <td>مبلغ قابل پرداخت</td>
        <td>{{ $final . ' تومان' }}</td>
    </tr>
</table>
@if($hour==18)
    <p class="mine"><strong>ساعت ارسال کالای شما : </strong>کالای شما از ساعت 18:30 الی 19:30 درب منزل شما تحویل می
        گردد.</p>
@else
    <p class="mine"><strong>ساعت ارسال کالای شما : </strong>کالای شما از ساعت {{ $hour }} الی {{ $hour+1 }} درب منزل شما
        تحویل می گردد.</p>
@endif
<table>
    <tr>
        <td>توضیحات</td>
        @if($description)
            <td>با عرض سلام و خسته نباشید. متشکرم.</td>
        @else
            <td>-</td>
        @endif
    </tr>
</table>
<br>
<p class="mine" style="text-align: center;">امضا فروشنده&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;امضا خریدار</p>
<br>
<p><strong>از حسن انتخاب شما متشکریم</strong></p>
</body>
</html>
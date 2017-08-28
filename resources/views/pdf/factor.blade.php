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
<h1 class="mine">با سلام</h1>
<h3 class="mine">
    از انتخاب و اعتماد شما متشکریم. شرح خرید شما بدین صورت می باشد :
</h3>
<br>
<table>
    <tr>
        <th>نام</th>
        <th>تعداد</th>
        <th>قیمت روی جلد</th>
        <th>قیمت نهایی</th>
    </tr>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->count }}</td>
            <td>{{ $product->price_original.' تومان' }}</td>
            <td>{{ $product->price.' تومان' }}</td>
        </tr>
    @endforeach
</table>
<br>
<p class="mine"><strong>مشخصات مشتری : </strong>{{ $user_name.' - '.$user_phone.' - '.$user_address }}</p>
<p class="mine"><strong>مجموع خرید : </strong>{{ $total.' تومان' }}</p>
<p class="mine"><strong>توضیحات : </strong>{{ $description }}</p>
<p class="mine"><strong>ساعت ارسال : </strong>{{ $hour }}</p>
</body>
</html>

<style>
    table tr:nth-child(even) {
        background-color: #eee;
    }

    table tr:nth-child(odd) {
        background-color: #fff;
    }

    table th {
        background-color: black;
        color: white;
    }
</style>

<table style="width: 100%">
    <tr>
        <th>تعداد فروش</th>
        <th>قیمت فروش</th>
        <th>تخفیف</th>
        <th>قیمت روی جلد</th>
        <th>قیمت خرید</th>
        <th>نام</th>
    </tr>
    @foreach($products as $product)
        <tr style="text-align: center">
            <td>{{ $product->sell }}</td>
            <td>{{ $product->price - ($product->off*$product->price/100) }}</td>
            <td>{{ $product->off }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->price_original }}</td>
            <td>{{ $product->name }}</td>
        </tr>
    @endforeach
</table>
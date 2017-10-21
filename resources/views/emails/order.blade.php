<p style="direction: rtl;">{{ $body }}</p>
<br>
<p style="direction: rtl;"><strong>نام کاربر</strong> : {{ $order['user_name'] }}</p>
<p style="direction: rtl;"><strong>شماره تماس</strong> : {{ $order['user_phone'] }}</p>
<p style="direction: rtl;"><strong>آدرس</strong> : {{ $order['address'] }}</p>
<br>
<p style="direction: rtl;"><strong>محصولات</strong> : {{ $order['stuffs'] }}</p>
<br>
<p style="direction: rtl;"><strong>ساعت ارسال</strong> : {{ $order['hour'] }}</p>
<p style="direction: rtl;"><strong>هزینه سبد خرید</strong> : {{ $order['price'].' تومان' }}</p>
@if($order['desc'])
    <p style="direction: rtl;"><strong>توضیحات</strong> : {{ $order['desc'] }}</p>
@else
    <p style="direction: rtl;"><strong>توضیحات</strong> : ندارد</p>
@endif
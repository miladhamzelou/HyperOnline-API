@extends('market.layout.base')

@section('content')
    <div id="content" class="col-sm-12">
        <h1 class="title">سبد خرید</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td class="text-center">تصویر</td>
                    <td class="text-center">نام محصول</td>
                    <td class="text-center">تعداد</td>
                    <td class="text-center">قیمت واحد</td>
                    <td class="text-center">کل</td>
                </tr>
                </thead>
                <tbody>
                @foreach($cart['items'] as $item)
                    <tr>
                        <td class="text-center">
                            <a href="product.html">
                                @if($item->options['image'])
                                    <img class="img-thumbnail"
                                         src="{{ asset('images').'/' . $item->options['image'] }}" width="50"
                                         height="50">
                                @else
                                    <img class="img-thumbnail"
                                         src="{{ asset('market/image/no_image.jpg')}}"
                                         width="50" height="50">
                                @endif
                            </a>
                        </td>
                        <td class="text-center">{{ $item->name }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-center">{{ ( $item->total / $item->qty ) . ' تومان' }}</td>
                        <td class="text-center">{{ $item->total . ' تومان' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-right"><strong>جمع کل</strong></td>
                        <td class="text-right">{{ $cart['subtotal'] . ' تومان' }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>مالیات / هزینه ارسال</strong></td>
                        <td class="text-right">{{ $cart['tax'] . ' تومان' }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>قابل پرداخت</strong></td>
                        <td class="text-right">{{ $cart['total'] . ' تومان' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="buttons">
            <div class="pull-center"><a href="{{ url('pay') }}" class="btn btn-primary" style="font-size: 18px">پرداخت</a></div>
            <div class="pull-center"><a href="{{ url('home') }}" class="btn btn-default" style="font-size: 18px">ادامه خرید</a></div>
        </div>
    </div>
@endsection
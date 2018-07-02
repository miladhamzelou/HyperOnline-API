@extends('market.layout.base')

@section('content')
    <h3 style="text-align: center">مشخصات شما</h3>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" style="width: 20%; text-align: center; background-color: #eee;">
                        <strong>نام</strong></td>
                    <td class="text-right">{{ $data['user']['name'] }}</td>
                </tr>
                <tr>
                    <td class="text-right" style="width: 20%; text-align: center; background-color: #eee;"><strong>شماره
                            تماس</strong></td>
                    <td class="text-right">{{ $data['user']['phone'] }}</td>
                </tr>
                <tr>
                    <td class="text-right" style="width: 20%; text-align: center; background-color: #eee;">
                        <strong>آدرس</strong></td>
                    <td class="text-right">{{ $data['user']['address'] }}</td>
                </tr>
            </table>
        </div>
    </div>
    <h3 style="text-align: center">قابل پرداخت</h3>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" style="text-align: center;">{{ number_format($data['pay']) . ' تومان' }}</td>
                </tr>
            </table>
        </div>
    </div>
    <h3 style="text-align: center">درگاه پرداخت</h3>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-bordered">
                <tr>
                    <td class="text-right" style="width: 10%; text-align: center; vertical-align: middle; !important;">
                        <input title="gateway" type="radio" value="0" checked>
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        <img src="http://www.sb24.com/dotAsset/1159138b-110a-4b8f-8d3f-363e4a5e805e.png"
                             style="width: 50px;height: 50px;">
                        پرداخت الکترونیک سامان
                    </td>
                </tr>
                <tr>
                    <td class="text-right" style="width: 10%; text-align: center; vertical-align: middle; !important;">
                        <input title="gateway" type="radio" value="0" disabled>
                    </td>
                    <td class="text-right" style="vertical-align: middle;">
                        <img src="https://www.rade.ir/images/logos/bnk_mellat_d.png"
                             style="width: 50px;height: 50px;">
                        بانک ملت
                        <span style="color: red; font-size: smaller;">( موقتا غیرفعال می باشد )</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="buttons">
        <div style="text-align: center">
            <a href="{{ url('website/pay') }}" class="btn btn-primary" style="font-size: 18px;  border-radius: 20px">پرداخت</a>
        </div>
    </div>
@endsection
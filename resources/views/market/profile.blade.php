@extends('market.layout.base')

@section('style')
    <style>
        .profile-header {
            margin: 20px 0 30px 0;
            width: 100%;
            height: auto;
            border-radius: 25px;
            background: white;
            border: 2px dashed hotpink;
            padding: 0 20px 0 20px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            position: absolute;
        }

        .profile-name {
            position: relative;
            text-align: center;
            margin-top: 90px;
        }

        .profile-meta {
            list-style-type: none;
            margin: 30px 0 30px 0;
        }

        .profile-title {
            display: inline;
            margin-left: 8px;
            font-weight: 600;
            font-size: large;
        }

        .profile-description {
            display: inline;
        }

        .profile-orders {
            border-radius: 20px;
            left: 50%;
            transform: translate(-50%, -50%);
            position: absolute;
            background: #e40571;
            color: white;
        }

        .profile-orders:hover {
            background: #e7e7e7;
            color: #444;
        }
    </style>
@endsection

@section('content')
    <div id="content" class="col-sm-12">
        <h2 style="text-align: right">حساب کاربری</h2>
        <br>
        <div class="profile-header">
            <img src="{{ asset('market/image/nobody.jpg') }}" class="profile-image">
            <h3 class="profile-name">{{ $user->name }}</h3>
            <br>
            <ul>
                <li class="profile-meta">
                    <p class="profile-title">شماره تماس :</p>
                    <p class="profile-description">{{ $user->phone }}</p>
                </li>
                <li class="profile-meta">
                    <p class="profile-title">آدرس :</p>
                    <p class="profile-description">{{ $user->state }} , {{ $user->city }} - {{ $user->address }}</p>
                </li>
                <li class="profile-meta">
                    <p class="profile-title">کیف پول :</p>
                    <p class="profile-description">{{ $user->wallet }} تومان</p>
                </li>
                <li class="profile-meta">
                    <p class="profile-title">کل سفارشات :</p>
                    <p class="profile-description">{{ $orders['totalCount'] }} سفارش در
                        مجموع {{ $orders['totalPrice'] }} تومان &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $orders['totalPlace'] }}
                        سفارش حضوری و {{ $orders['totalPlace'] }} سفارش انلاین</p>
                </li>
                <li class="profile-meta">
                    <p class="profile-title">وضعیت حساب :</p>
                    @if($user->confirmed_info)
                        <p class="profile-description" style="color: green">تایید شده</p>
                    @else
                        <p class="profile-description" style="color: red">تایید نشده</p>
                    @endif
                </li>
                <li class="profile-meta">
                    <p class="profile-title">وضعیت شماره تماس :</p>
                    @if($user->confirmed_phone)
                        <p class="profile-description" style="color: green">تایید شده</p>
                    @else
                        <p class="profile-description" style="color: red">تایید نشده</p>
                    @endif
                </li>
            </ul>
            <br>
            <a class="btn btn-default btn-lg profile-orders" href="{{ url('orders') }}" target="_blank">پیگیری
                سفارشات</a>
        </div>
    </div>
@endsection
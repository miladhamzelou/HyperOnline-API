@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">User Information</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6" style="text-align: center; direction: rtl;">
                                <table class="table no-margin">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->code }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->address }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->wallet.' تومان' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->state }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->city }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">
                                            @if($user->district)
                                                {{ $user->district }}
                                            @else
                                                -
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="@if($user->confirmed_phone)color:limegreen;@else color:red;@endif text-align: right; direction: rtl;">
                                            @if($user->confirmed_phone)
                                                تایید شده
                                            @else
                                                تایید نشده
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">
                                            @if($user->location_x)
                                                {{ $user->location_x }}
                                            @else
                                                -
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">
                                            @if($user->location_y)
                                                {{ $user->location_y }}
                                            @else
                                                -
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="@if($user->active)color:limegreen;@else color:red;@endif text-align: right; direction: rtl;">
                                            @if($user->active)
                                                فعال
                                            @else
                                                غیرفعال
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->role }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: ltr;">{{ $user->create_date }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: ltr;">
                                            @if($user->update_date)
                                                {{ $user->update_date }}
                                            @else
                                                -
                                            @endif</td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6" style="text-align: center; direction: rtl;">
                                <table class="table no-margin">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">کد مشتری</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">نام</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">شماره تماس</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">آدرس</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">کیف پول</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">استان</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">شهر</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">منطقه</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">تایید تلفن همراه</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">آخرین مختصات</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">آخرین مختصات</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">وضعیت</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">سطح کاربری</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">تاریخ ثبت نام</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">آخرین به روز رسانی</td>
                                    </tr>
                                    <tr>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
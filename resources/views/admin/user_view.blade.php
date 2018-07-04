@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-9 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">اطلاعات کاربر</h2>
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
                                    {{--<tr>--}}
                                    {{--<td style="text-align: right; direction: rtl;">{{ $user->wallet.' تومان' }}</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->state }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">{{ $user->city }}</td>
                                    </tr>
                                    {{--<tr>--}}
                                    {{--<td style="text-align: right; direction: rtl;">--}}
                                    {{--@if($user->district)--}}
                                    {{--{{ $user->district }}--}}
                                    {{--@else--}}
                                    {{-----}}
                                    {{--@endif</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td style="@if($user->confirmed_phone)color:limegreen;@else color:red;@endif text-align: right; direction: rtl;">
                                            @if($user->confirmed_phone)
                                                تایید شده
                                            @else
                                                تایید نشده
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="@if($user->confirmed_info)color:limegreen;@else color:red;@endif text-align: right; direction: rtl;">
                                            @if($user->confirmed_info)
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
                                        <td style="text-align: right; direction: rtl;">{{ $user->wallet->price . ' تومان' }}</td>
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
                                        <td style="text-align: right; direction: ltr;">{{ $user->password }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: ltr;">{{ $user->android }}</td>
                                    </tr>
                                    @if($presenter!="null")
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/users/' . $presenter->unique_id) }}"
                                                   target="_blank">{{ $presenter->name }}</a></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td style="text-align: right; direction: ltr;">ندارد</td>
                                        </tr>
                                    @endif
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
                                    {{--<tr>--}}
                                    {{--<td style="text-align: right; direction: rtl;">کیف پول</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">استان</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">شهر</td>
                                    </tr>
                                    {{--<tr>--}}
                                    {{--<td style="text-align: right; direction: rtl;">منطقه</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">تایید تلفن همراه</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">تایید اطلاعات</td>
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
                                        <td style="text-align: right; direction: rtl;">کیف پول</td>
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
                                        <td style="text-align: right; direction: rtl;">رمز عبور</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">نسخه اندروید</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; direction: rtl;">معرف</td>
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

    <div class="row">
        <div class="col-lg-9 col-centered center-block" style="float: none;">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h2 class="box-title">تنظیمات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <br>
                        <a class="btn btn-success pull-right btn-lg" tabindex="1" style="margin-left: 5px"
                           href="{{ url('admin/confirm/' . $user->unique_id . '/1') }}">تایید اطلاعات</a>
                        <a class="btn btn-danger pull-right btn-lg" tabindex="2" style="margin-left: 10px"
                           href="{{ url('admin/confirm/' . $user->unique_id . '/0') }}">عدم تایید اطلاعات</a>
                        <a class="btn btn-warning pull-right btn-lg" tabindex="3"
                           href="{{ url('admin/pop/' . $user->unique_id) }}">خروج اجباری کاربر</a>
                        <br>
                        <br>
                        <br>
                        <h3 style="text-align: center">ارسال پیام</h3>
                        <br>
                        <form role="form" action="/admin/confirm/message" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $user->unique_id }}">

                            <div class="text-right form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body" style="direction: rtl">متن پیام :</label>
                                <textarea id="body" type="text" style="text-align: center; direction: rtl"
                                          class="my_font form-control"
                                          name="body" tabindex="4" required></textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="5" name="send"
                                       class="my_font btn center-block btn-lg btn-success" value="ارسال">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
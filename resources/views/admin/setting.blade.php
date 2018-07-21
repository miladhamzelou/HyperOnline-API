@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-9 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">تنظیمات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <a href="{{ url('management/setting/delete_log') }}" tabindex="1" class="btn btn-danger  btn-lg">حذف
                            لاگ</a>
                        <a href="{{ url('management/setting/resetMostSell') }}" tabindex="2" class="btn btn-danger  btn-lg">صفر
                            کردن فروش</a>
                        <a href="{{ url('management/setting/confirmAllPhones') }}" tabindex="3"
                           class="btn btn-warning  btn-lg">تایید شماره ها</a>
                        <hr>
                        <form role="form" action="/management/setting/updateOffline" method="post">
                            <div class="row" style="padding-right: 15px;padding-left: 15px">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   @if($offline['off']) checked @endif id="offline"
                                                   name="offline" tabindex="4">بسته بودن فروشگاه
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                    <label for="message" class="pull-right" style="direction:rtl;">علت تعطیلی :</label>
                                    <input id="message" type="text" style="text-align: center"
                                           class="my_font form-control"
                                           name="message" tabindex="5" value="{{ $offline['off_msg'] }}">

                                    @if ($errors->has('message'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="6" name="publish"
                                       class="my_font btn center-block btn-lg btn-success" value="ثبت">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
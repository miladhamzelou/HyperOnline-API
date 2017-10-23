@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">تنظیمات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <a href="{{ url('admin/setting/delete_log') }}" tabindex="1" class="btn btn-danger  btn-lg">حذف
                            لاگ</a>
                        <a href="{{ url('admin/setting/resetMostSell') }}" tabindex="2" class="btn btn-danger  btn-lg">صفر
                            کردن فروش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
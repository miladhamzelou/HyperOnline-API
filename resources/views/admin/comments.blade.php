@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-12 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">لیست نظرات</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!count($comments))
                            <br>
                            <p style="text-align: center">نظری ثبت نشده است</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">تاریخ</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">متن پیام</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام مشتری</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">{{ $comment->create_date }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $comment->body }}</td>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/users/' . $comment->user_id) }}">
                                                    {{ $comment->user_name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
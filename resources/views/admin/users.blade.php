@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-8 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">لیست کاربران</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$users->count())
                            <br>
                            <p style="text-align: center">کاربری وجود ندارد</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">آدرس</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">شماره تماس</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">{{ $user->address }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $user->phone }}</td>
                                            <td style="text-align: right; direction: rtl;"><a
                                                        href="{{ url('/admin/users/'.$user->unique_id) }}">{{ $user->name }}</a>
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
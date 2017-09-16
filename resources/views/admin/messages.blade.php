@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('reports')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">پیامک ها</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        @if(!count($sms))
                            <br>
                            <p style="text-align: center">تاکنون پیامکی ارسال نشده است</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">تاریخ</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">وضعیت</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">مخاطب</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">محتوا</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sms as $item)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">{{ $item->created_at }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $item->response }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $item->to }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $item->message }}</td>
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
        <div class="col-lg-6">
            <div class="box box-info">
                    <div class="box-header with-border">
                        <h2 class="box-title">پوش ها</h2>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div class="box-body">
                            <br>
                            @if(!count($push))
                                <br>
                                <p style="text-align: center">تاکنون پوش ارسال نشده است</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th style="font-size:17px; text-align: right; direction: rtl;">تاریخ</th>
                                            <th style="font-size:17px; text-align: right; direction: rtl;">محتوا</th>
                                            <th style="font-size:17px; text-align: right; direction: rtl;">عنوان</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($push as $item)
                                            <tr>
                                                <td style="text-align: right; direction: rtl;">{{ $item->created_at }}</td>
                                                <td style="text-align: right; direction: rtl;">{{ $item->body }}</td>
                                                <td style="text-align: right; direction: rtl;">{{ $item->title }}</td>
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
    </div>
@endsection

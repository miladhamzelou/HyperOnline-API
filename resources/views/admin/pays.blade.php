@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-7 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">آخرین تراکنش ها</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$pays->count())
                            <p>There is no Payment</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">زمان</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">وضعیت</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">شماره کارت</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">شماره فاکتور</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">کد سفارش</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pays as $pay)
                                        <tr>
                                            <td style="text-align: right; direction: ltr;">{{ $pay->created_at }}</td>
                                            @if($pay->status)
                                                <td style="color:limegreen;text-align: right; direction: ltr;">موفقیت
                                                    آمیز
                                                </td>
                                            @else
                                                <td style="color:red;text-align: right; direction: ltr;">خطا</td>
                                            @endif
                                            <td style="text-align: right; direction: ltr;">{{ $pay->cardNumber }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $pay->factorNumber }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $pay->transId }}</td>
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
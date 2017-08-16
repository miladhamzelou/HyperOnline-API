@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-9 col-centered center-block" style="float: none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Last Authors</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$authors->count())
                            <p>There is no author</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">آدرس</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">تلفن ثابت</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">موبایل</th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($authors as $author)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">{{ $author->address }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $author->phone }}</td>
                                            <td style="text-align: right; direction: rtl;">{{ $author->mobile }}</td>
                                            <td style="text-align: right; direction: rtl;"><a
                                                        href="{{ url('/admin/authors/'.$author->unique_id) }}">{{ $author->name }}</a>
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
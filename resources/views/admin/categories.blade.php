@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('list')
    <div class="row">
        <div class="col-lg-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h2 class="box-title">مرحله ۳</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$categories3->count())
                            <br>
                            <p style="text-align: center;">دسته بندی وجود ندارد</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">دسته بندی والد
                                        </th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories3 as $category)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/categories/2/'.$category->parent_id) }}">
                                                    {{ $category->parent_name }}
                                                </a>
                                            </td>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/categories/3/'.$category->unique_id) }}">
                                                    {{ $category->name }}
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

        <div class="col-lg-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title">مرحله ۲</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$categories2->count())
                            <br>
                            <p style="text-align: center;">دسته بندی وجود ندارد</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">دسته بندی والد
                                        </th>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories2 as $category)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/categories/1/'.$category->parent_id) }}">
                                                    {{ $category->parent_name }}
                                                </a>
                                            </td>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/categories/2/'.$category->unique_id) }}">
                                                    {{ $category->name }}
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

        <div class="col-lg-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">مرحله ۱</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$categories1->count())
                            <br>
                            <p style="text-align: center;">دسته بندی وجود ندارد</p>
                        @else
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th style="font-size:17px; text-align: right; direction: rtl;">نام</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories1 as $category)
                                        <tr>
                                            <td style="text-align: right; direction: rtl;">
                                                <a href="{{ url('/admin/categories/1/'.$category->unique_id) }}">
                                                    {{ $category->name }}
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
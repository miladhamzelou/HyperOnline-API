@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h2 class="box-title">وب سایت</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h2 class="box-title">اپلیکیشن</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        @if(!$banners->count())
                            <br>
                            <p style="text-align: center; direction: rtl;">بنری ثبت نشده است</p>
                        @else
                            <ul class="products-list products-list-in-box">
                                @foreach($banners as $banner)
                                    <li class="item">
                                        <div class="product-img">
                                            @if(!$banner->image)
                                                <img src="{{ asset('dist/img/default-50x50.gif') }}">
                                            @else
                                                <img src="{{ asset('images/' . $banner->image) }}">
                                            @endif
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ url('/admin/banners/'.$banner->unique_id) }}"
                                               class="product-title">
                                                {{ $banner->title }}
                                            </a>
                                        </div>
                                    </li>
                                    <br>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
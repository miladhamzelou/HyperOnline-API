@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">اطلاعات کالا</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <form role="form" action="/admin/products/create" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('seller') ? ' has-error' : '' }}">
                                        <label for="seller" class="pull-right" style="direction:rtl;">فروشنده :</label>
                                        <select id="seller" type="text" style="text-align: center"
                                                class="my_font form-control" tabindex="5"
                                                name="seller" required>
                                            <option>انتخاب کنید</option>
                                            @foreach($sellers as $seller)
                                                <option>{{ $seller }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('seller'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('seller') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label for="category" class="pull-right" style="direction:rtl;">دسته بندی
                                            :</label>
                                        <select id="category" type="text" style="text-align: center"
                                                class="my_font form-control" tabindex="6"
                                                name="category" required>
                                            <option>انتخاب کنید</option>
                                            @foreach($categories as $category)
                                                <option>{{ $category }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('category'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="0" checked>
                                            عادی
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="1">
                                            سبد خرید
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="2">
                                            مناسبتی
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="Name" class="pull-right" style="direction:rtl;">نام :</label>
                                        <input id="name" type="text" style="text-align: center"
                                               class="my_font form-control"
                                               name="name" tabindex="1" required>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <label for="description" class="pull-right" style="direction:rtl;">توضیحات
                                            :</label>
                                        <input id="description" type="text" style="text-align: center"
                                               tabindex="2"
                                               class="my_font form-control"
                                               name="description">

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label for="price" class="pull-right" style="direction:rtl;">قیمت ( تومان )
                                            :</label>
                                        <input id="price" type="number" style="text-align: center"
                                               class="my_font form-control" tabindex="3"
                                               name="price" required>

                                        @if ($errors->has('price'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('count') ? ' has-error' : '' }}">
                                        <label for="count" class="pull-right" style="direction:rtl;">تعداد :</label>
                                        <input id="count" type="number" style="text-align: center" tabindex="4"
                                               class="my_font form-control" value="1"
                                               name="count" required>

                                        @if ($errors->has('count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('count') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <br>
                                    <br>
                                    <div class="center-block form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <label for="image" class="pull-right" style="direction:rtl;">عکس :</label>
                                        <input id="image" type="file" tabindex="7"
                                               name="image" accept="image/jpeg, image/png, image/gif">

                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <br>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <input type="submit" tabindex="8" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-success" value="ثبت کردن">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
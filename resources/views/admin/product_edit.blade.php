@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h2 class="box-title">اطلاعات محصول</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <form role="form" action="/admin/products/update" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('seller') ? ' has-error' : '' }}">
                                        <label for="seller" class="pull-right" style="direction: rtl;">فروشنده :</label>
                                        <select id="seller" style="text-align: center"
                                                class="my_font form-control" tabindex="5"
                                                name="seller" required autocomplete="off">
                                            @foreach($sellers as $seller)
                                                @if(!strcmp($seller,$seller_selected))
                                                    <option selected="selected">{{ $seller }}</option>
                                                @else
                                                    <option>{{ $seller }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @if ($errors->has('seller'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('seller') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label for="category" class="pull-right" style="direction: rtl;">دسته بندی
                                            :</label>
                                        <select id="category" style="text-align: center"
                                                class="my_font form-control" tabindex="6"
                                                name="category" required autocomplete="off">
                                            @foreach($categories as $category)
                                                @if(!strcmp($category, $category_selected))
                                                    <option selected="selected">{{ $category }}</option>
                                                @else
                                                    <option>{{ $category }}</option>
                                                @endif
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
                                                   id="type" value="0" {{ $product->type==0 ? 'checked' : '' }}>
                                            عادی
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="1" {{ $product->type==1 ? 'checked' : '' }}>
                                            سبد خرید
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="2" {{ $product->type==2 ? 'checked' : '' }}>
                                            مناسبتی
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="unique_id" value="{{ $product->unique_id }}">

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="Name" class="pull-right" style="direction: rtl;">نام :</label>
                                        <input id="name" type="text" style="text-align: center"
                                               class="my_font form-control"
                                               name="name" tabindex="1" required value="{{ $product->name }}">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <label for="description" class="pull-right" style="direction: rtl;">توضیحات
                                            :</label>
                                        <input id="description" type="text" style="text-align: center; direction: rtl"
                                               tabindex="2"
                                               class="my_font form-control"
                                               name="description" value="{{ $product->description }}">

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('price_original') ? ' has-error' : '' }}">
                                        <label for="price_original" class="pull-right" style="direction:rtl;">قیمت خرید
                                            ( تومان )
                                            :</label>
                                        <input id="price_original" type="number" style="text-align: center"
                                               class="my_font form-control" tabindex="4"
                                               name="price_original" value="{{ $product->price_original }}" required>

                                        @if ($errors->has('price_original'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('price_original') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label for="price" class="pull-right" style="direction: rtl;">قیمت روی جلد (
                                            تومان ) :</label>
                                        <input id="price" type="number" style="text-align: center"
                                               class="my_font form-control" tabindex="3"
                                               name="price" required value="{{ $product->price }}">

                                        @if ($errors->has('price'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('count') ? ' has-error' : '' }}">
                                        <label for="count" class="pull-right" style="direction: rtl;">تعداد :</label>
                                        <input id="count" type="number" style="text-align: center" tabindex="4"
                                               class="my_font form-control"
                                               name="count" required value="{{ $product->count }}">

                                        @if ($errors->has('count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('off') ? ' has-error' : '' }}">
                                        <label for="off" class="pull-right" style="direction:rtl;">تخفیف ( درصد )
                                            :</label>
                                        <input id="off" type="number" style="text-align: center" tabindex="6"
                                               class="my_font form-control" value="{{ $product->off }}"
                                               name="off" required>

                                        @if ($errors->has('off'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('off') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($product->image)
                                <hr>
                                <br>
                                <img src="{{ asset('images/' . $product->image) }}" class="center-block"
                                     alt="{{ $product->name }}" width="250px" height="250px">
                                <br>
                                <br>
                            @else
                                <br>
                            @endif
                            <div class="center-block form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                @if($product->image)
                                    <label for="image" class="pull-right" style="direction:rtl;">عکس جدید :</label>
                                @else
                                    <label for="image" class="pull-right" style="direction:rtl;">عکس :</label>
                                @endif
                                <input id="image" type="file" tabindex="7"
                                       name="image" accept="image/jpeg, image/png, image/gif">

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="7" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-warning"
                                       value="اعمال تغییرات">
                            </div>

                            <div class="form-group">
                                <a class="btn btn-danger center-block btn-lg style="
                                   href="{{ url('admin/products/delete_photo/'.$product->unique_id) }}">حذف عکس</a>
                            </div>

                            <div class="form-group">
                                <a class="btn btn-danger center-block btn-lg"
                                   href="{{ url('admin/products/delete/'.$product->unique_id) }}">حذف محصول</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
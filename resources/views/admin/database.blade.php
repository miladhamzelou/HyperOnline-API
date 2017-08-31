@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-12 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">تنظیمات پایگاه داده</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <form role="form" action="/admin/settings" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="unique_id" value="{{ $option->unique_id }}">
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('collection_count') ? ' has-error' : '' }}">
                                        <label for="collection_count">سبد کالا</label>
                                        <input id="collection_count" type="number" style="text-align: center"
                                               placeholder="collection_count"
                                               class="my_font form-control"
                                               name="collection_count" tabindex="1" required
                                               value="{{ $option->collection_count }}">

                                        @if ($errors->has('collection_count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('collection_count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @if($option->collection) checked @endif id="collection"
                                                       name="collection">نشان داده شود
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('most_sell_count') ? ' has-error' : '' }}">
                                        <label for="most_sell_count">پرفروش ترین ها</label>
                                        <input id="most_sell_count" type="number" style="text-align: center"
                                               placeholder="most_sell_count"
                                               class="my_font form-control"
                                               name="most_sell_count" tabindex="1" required
                                               value="{{ $option->most_sell_count }}">

                                        @if ($errors->has('most_sell_count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('most_sell_count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @if($option->most_sell) checked @endif id="most_sell"
                                                       name="most_sell">نشان داده شود
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('popular_count') ? ' has-error' : '' }}">
                                        <label for="popular_count">محبوب ترین ها</label>
                                        <input id="popular_count" type="number" style="text-align: center"
                                               placeholder="popular_count"
                                               class="my_font form-control"
                                               name="popular_count" tabindex="1" required
                                               value="{{ $option->popular_count }}">

                                        @if ($errors->has('popular_count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('popular_count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @if($option->popular) checked @endif id="popular"
                                                       name="popular">نشان داده شود
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('new_count') ? ' has-error' : '' }}">
                                        <label for="new_count">جدیدترین ها</label>
                                        <input id="new_count" type="number" style="text-align: center"
                                               placeholder="new_count"
                                               class="my_font form-control"
                                               name="new_count" tabindex="1" required
                                               value="{{ $option->new_count }}">

                                        @if ($errors->has('new_count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('new_count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @if($option->new) checked @endif id="new"
                                                       name="new">نشان داده شود
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('off_count') ? ' has-error' : '' }}">
                                        <label for="off_count">تخفیف خورده ها</label>
                                        <input id="off_count" type="number" style="text-align: center"
                                               placeholder="off_count"
                                               class="my_font form-control"
                                               name="off_count" tabindex="1" required
                                               value="{{ $option->off_count }}">

                                        @if ($errors->has('off_count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('off_count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @if($option->off) checked @endif id="off"
                                                       name="off">نشان داده شود
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('category_count') ? ' has-error' : '' }}">
                                        <label for="category_count">دسته بندی ها</label>
                                        <input id="category_count" type="number" style="text-align: center"
                                               placeholder="category_count"
                                               class="my_font form-control"
                                               name="category_count" tabindex="1" required
                                               value="{{ $option->category_count }}">

                                        @if ($errors->has('category_count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('category_count') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @if($option->category) checked @endif id="category"
                                                       name="category">نشان داده شود
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="3" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-danger" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
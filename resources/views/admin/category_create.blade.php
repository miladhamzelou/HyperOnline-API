@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-4 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">اطلاعات دسته بندی - مرحله : {{ $level }}</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <form role="form" action="/admin/categories/create/{{ $level }}" enctype="multipart/form-data"
                              method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @if($level!="1")
                                <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                                    <label for="parent" class="pull-right" style="direction:rtl;">دسته بندی والد
                                        :</label>
                                    <select id="parent" type="text" style="text-align: center"
                                            class="my_font form-control" tabindex="1"
                                            name="parent" required>
                                        <option>انتخاب کنید</option>
                                        @foreach($categories as $category)
                                            <option>{{ $category }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('parent'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            @endif

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
                                <br>
                            </div>

                            <div class="center-block form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="pull-right" style="direction:rtl;">عکس :</label>
                                <input id="image" type="file" tabindex="7"
                                       name="image" accept="image/jpeg, image/png, image/gif">

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                                <br>
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="3" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-success" value="ثبت کردن">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
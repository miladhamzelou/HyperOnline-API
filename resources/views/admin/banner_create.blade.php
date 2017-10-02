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
                        <form role="form" action="/admin/banners/create" method="post" enctype="multipart/form-data">
                            <div class="row" style="padding-right: 15px;padding-left: 15px">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="title" class="pull-right" style="direction:rtl;">عنوان :</label>
                                    <input id="title" type="text" style="text-align: center"
                                           class="my_font form-control"
                                           name="title" tabindex="1" required>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                                    <label for="link" class="pull-right" style="direction:rtl;">لینک :</label>
                                    <input id="link" type="text" style="text-align: center"
                                           class="my_font form-control"
                                           name="link" tabindex="2">

                                    @if ($errors->has('link'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <br>
                                <div class="form-check pull-right">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="type"
                                               id="type" value="0" checked>
                                        اپلیکیشن
                                    </label>
                                </div>
                                <br>
                                <br>
                                <div class="form-check pull-right">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="type"
                                               id="type" value="1" disabled>
                                        وب سایت
                                    </label>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="center-block form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="pull-right" style="direction:rtl;">عکس :</label>
                                <input id="image" type="file" tabindex="3"
                                       name="image" accept="image/jpeg, image/png, image/gif">

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="4" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-success" value="ثبت کردن">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
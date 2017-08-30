@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">Support</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <form role="form" action="/admin/support" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                <label for="section">بخش مربوطه :</label>
                                <input id="section" type="text" style="text-align: center"
                                       class="my_font form-control"
                                       name="section" tabindex="1" required>

                                @if ($errors->has('section'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="text-right form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body">متن درخواست :</label>
                                <textarea id="body" type="text" style="text-align: center"
                                          class="my_font form-control"
                                          name="body" tabindex="1" required></textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               id="log" checked
                                               name="log">فایل لاگ ارسال شود
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="1" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-danger" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
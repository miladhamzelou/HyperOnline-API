@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">New Author</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <form role="form" action="/admin/authors/create" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        <label for="state" style="text-align: center; direction: rtl;">استان :</label>
                                        <input id="state" type="text" style="text-align: center" placeholder="state"
                                               class="my_font form-control"
                                               name="state" tabindex="1" disabled required value="همدان">

                                        @if ($errors->has('state'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        <label for="city" style="text-align: center; direction: rtl;">شهر :</label>
                                        <input id="city" type="text" style="text-align: center" placeholder="city"
                                               class="my_font form-control"
                                               name="city" tabindex="1" disabled required value="همدان">

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label for="address" style="text-align: center; direction: rtl;">آدرس :</label>
                                        <input id="address" type="text" style="text-align: center" placeholder="address"
                                               class="my_font form-control"
                                               name="address" tabindex="1" required>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="Name" style="text-align: center; direction: rtl;">نام کامل :</label>
                                        <input id="name" type="text" style="text-align: center" placeholder="name"
                                               class="my_font form-control"
                                               name="name" tabindex="1" required>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" style="text-align: center; direction: rtl;">تلفن ثابت
                                            :</label>
                                        <input id="phone" type="tel" style="text-align: center"
                                               placeholder="phone" tabindex="2"
                                               class="my_font form-control"
                                               name="phone" required>

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                        <label for="mobile" style="text-align: center; direction: rtl;">موبایل :</label>
                                        <input id="mobile" type="tel" style="text-align: center" placeholder="mobile"
                                               class="my_font form-control" tabindex="3"
                                               name="mobile" required>

                                        @if ($errors->has('mobile'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('mCode') ? ' has-error' : '' }}">
                                        <label for="mCode" style="text-align: center; direction: rtl;">کد ملی :</label>
                                        <input id="mCode" type="text" style="text-align: center" tabindex="4"
                                               class="my_font form-control"
                                               name="mCode" required>

                                        @if ($errors->has('mCode'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('mCode') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="7" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-danger" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
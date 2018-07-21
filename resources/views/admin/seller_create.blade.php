@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">New Seller</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <form role="form" action="/management/sellers/create" method="post">
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

                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" style="text-align: center; direction: rtl;">تلفن :</label>
                                        <input id="phone" type="text" style="text-align: center" placeholder="phone"
                                               class="my_font form-control"
                                               name="phone" tabindex="1" required>

                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="0" checked>
                                            فروشگاه شخصی
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="1">
                                            فروشگاه غیرشخصی
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
                                        <label for="author">فروشنده :</label>
                                        <select id="author" type="text" style="text-align: center"
                                                class="my_font form-control" tabindex="6"
                                                name="author" required>
                                            <option>Choose ...</option>
                                            @foreach($authors as $author)
                                                <option>{{ $author }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('author'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('author') }}</strong>
                                    </span>
                                        @endif
                                    </div>

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

                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label for="address" style="text-align: center; direction: rtl;">آدرس
                                            :</label>
                                        <input id="address" type="text" style="text-align: center"
                                               placeholder="address" tabindex="2"
                                               class="my_font form-control"
                                               name="address" required>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('open_hour') ? ' has-error' : '' }}">
                                        <label for="open_hour" style="text-align: center; direction: rtl;">ساعت شروع به کار :</label>
                                        <input id="open_hour" type="number" style="text-align: center"
                                               class="my_font form-control" tabindex="3"
                                               name="open_hour" required>

                                        @if ($errors->has('open_hour'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('open_hour') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('close_hour') ? ' has-error' : '' }}">
                                        <label for="close_hour" style="text-align: center; direction: rtl;">ساعت پایان کار :</label>
                                        <input id="close_hour" type="number" style="text-align: center" tabindex="4"
                                               class="my_font form-control"
                                               name="close_hour" required>

                                        @if ($errors->has('close_hour'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('close_hour') }}</strong>
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
@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">ارسال پیام جدید</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <br>
                        <p style="text-align: center; color: red;">پیامک فقط به کاربرانی که شماره تلفن تایید شده داشته باشند ارسال خواهد شد</p>
                        <br>
                        <form role="form" action="/admin/messages/sms" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="text-right form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body" style="direction: rtl">متن پیام :</label>
                                <textarea id="body" type="text" style="text-align: center"
                                          class="my_font form-control"
                                          name="body" tabindex="1" required></textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="2" name="send"
                                       class="my_font btn center-block btn-lg btn-success" value="ارسال">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
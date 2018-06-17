@extends('market.layout.base')

@section('content')
    <div id="content" class="col-sm-12">
        <h1 style="text-align: center">ثبت نظرات / شکایات</h1>
        <br>
        <div class="row">
            <div class="col-lg-9 col-centered center-block" style="float: none;">
                <p>لطفا نظرات پیشنهادات یا شکایات خود را از طریق فرم زیر با ما در میان بگذارید</p>
                <br>
                <form role="form" action="/comment/send" method="post">
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
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block" style="color: red">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                    {!! NoCaptcha::renderJs('fa') !!}
                    {!! NoCaptcha::display() !!}
                    <div class="form-group">
                        <input type="submit" tabindex="2" name="send"
                               class="my_font btn center-block btn-lg btn-success" value="ارسال">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
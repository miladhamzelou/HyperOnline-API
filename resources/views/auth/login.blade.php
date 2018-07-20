@extends('auth.app')

@section('content')
    <div class="col-lg-4">
    </div>
    <div class="col-lg-4">
        <div class="form-box">
            <div class="form-top">
                <div class="form-top-left">
                    <h3>ورود</h3>
                    <p>اطلاعات کاربری را وارد نمایید :</p>
                </div>
                <div class="form-top-right">
                    <i class="fa fa-key"></i>
                </div>
            </div>
            <div class="form-bottom">
                <form role="form" action="{{ route('login') }}" method="POST" class="login-form">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="number" name="phone" placeholder="شماره تلفن"
                               class="form-control" id="phone" value="{{ old('phone') }}" style="text-align: center">
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" name="password" placeholder="رمز عبور"
                               class="form-control" id="password" value="{{ old('password') }}">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                    {!! NoCaptcha::renderJs('fa') !!}
                    {!! NoCaptcha::display() !!}
                    <button type="submit" class="btn">ورود</button>
                </form>
                <p style="text-align: center; margin-top: 10px">حساب کاربری ندارید ؟ <a href="{{ route('register') }}">ثبت
                        نام کنید</a></p>
            </div>
        </div>
    </div>
@endsection

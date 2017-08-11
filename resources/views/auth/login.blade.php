@extends('auth.app')

@section('content')
    <div class="container">
        <div class="wrapper">
            <form role="form" method="POST" action="{{ route('login') }}" class="form-signin">
                {{ csrf_field() }}
                <h3 class="form-signin-heading my_font">سلام ... خوش آمدید !!<br>جهت ورود اطلاعات خود را وارد کنید</h3>
                <hr class="colorgraph">
                <br>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="my_font form-control" style="text-align: center" name="email"
                           value="{{ old('email') }}" placeholder="آدرس ایمیل" required>

                    @if ($errors->has('email'))
                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" style="text-align: center" placeholder="رمز عبور"
                           class="my_font form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Remember Me :)
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="my_font btn btn-block btn3d btn-lg btn-info">ورود</button>
                </div>

                <a class="btn btn-link btn-block my_font" href="{{ route('password.request') }}">رمز عبور خود را فراموش
                    کرده
                    اید
                    ؟</a>
            </form>
            <br>
            <div class="flex-center">
                <h6 class="">Coded With <span class="fa fa-heart pulse2"></span> By Arash Hatami</h6>
            </div>
        </div>
    </div>
@endsection
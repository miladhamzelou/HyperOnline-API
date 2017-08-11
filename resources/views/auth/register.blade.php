@extends('auth.app')

@section('content')
    <div class="container">
        <div class="wrapper">
            <form class="form-signin" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <h3 class="form-signin-heading my_font">سلام ... خوش آمدید !!<br>جهت ثبت نام اطلاعات خود را وارد کنید
                </h3>
                <hr class="colorgraph">
                <br>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input id="name" type="text" style="text-align: center" placeholder="نام و نام خانوادگی"
                           class="my_font form-control"
                           name="name"
                           value="{{ old('name') }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" style="text-align: center" placeholder="آدرس ایمیل"
                           class="my_font form-control"
                           name="email"
                           value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <input id="phone" type="text" style="text-align: center" placeholder="شماره تلفن"
                           class="my_font form-control" name="phone"
                           value="{{ old('phone') }}" required>

                    @if ($errors->has('phone'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" style="text-align: center" placeholder="رمز عبور"
                           class="my_font form-control"
                           name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <input id="password-confirm" type="password" class="my_font form-control"
                           name="password_confirmation" style="text-align: center" required
                           placeholder="تکرار رمز عبور">
                </div>

                <div class="form-group">
                    <button type="submit" class="my_font btn btn-block btn3d btn-lg btn-info">ثبت نام</button>
                </div>
            </form>
            <br>
            <div class="flex-center">
                <h6 class="">Coded With <span class="fa fa-heart pulse2"></span> By Arash Hatami</h6>
            </div>
        </div>
    </div>
@endsection
@extends('auth.app')

@section('content')
    <div class="container">
        <div class="wrapper">
            <form role="form" method="POST" action="{{ route('login') }}" class="form-signin">
                {{ csrf_field() }}
                <h3 class="form-signin-heading font">سلام ... خوش آمدید !!<br>جهت ورود اطلاعات خود را وارد کنید</h3>
                <hr class="colorgraph">
                <br>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <input id="phone" type="tel" class="font form-control" style="text-align: center" name="phone"
                           value="{{ old('phone') }}" placeholder="شماره تلفن" required>

                    @if ($errors->has('phone'))
                        <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" style="text-align: center" placeholder="رمز عبور"
                           class="font form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>

                <br>
                <div class="form-group">
                    <button type="submit" class="font btn btn-block btn3d btn-lg btn-info">ورود</button>
                </div>
            </form>
            <br>
            <div class="flex-center">
                <h6 class="">Coded With <span class="fa fa-heart pulse2"></span> By Arash Hatami</h6>
            </div>
        </div>
    </div>
@endsection
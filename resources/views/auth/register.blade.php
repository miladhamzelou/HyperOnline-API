@extends('auth.app')

@section('content')
    <div class="container">
        <div class="wrapper">
            <form class="form-signin" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <h3 class="form-signin-heading font">جهت ثبت نام اطلاعات خود را وارد کنید
                </h3>
                <hr class="colorgraph">
                <br>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input id="name" type="text" style="text-align: center" placeholder="نام و نام خانوادگی"
                                   class="font form-control"
                                   name="name"
                                   tabindex="1"
                                   value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input id="phone" type="number" style="text-align: center" placeholder="شماره تلفن"
                                   class="font form-control" name="phone" tabindex="2"
                                   value="{{ old('phone') }}" required>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" style="text-align: center" placeholder="رمز عبور"
                                   class="font form-control" tabindex="3"
                                   name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" class="font form-control"
                                   name="password_confirmation" style="text-align: center" required tabindex="4"
                                   placeholder="تکرار رمز عبور">
                        </div>

                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}" hidden>
                            <input id="state" type="text" style="text-align: center" placeholder="استان"
                                   class="font form-control"
                                   name="state"
                                   value="همدان" disabled required>

                            @if ($errors->has('state'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="city-label" style="">شهر :</label>
                            <select id="city" type="text" style="text-align: center"
                                    class="font form-control"
                                    name="city"
                                    required>
                                <option>همدان</option>
                                <option>مریانج</option>
                                <option>بهار</option>
                            </select>

                            @if ($errors->has('city'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <input id="address" type="text" style="text-align: center" placeholder="آدرس کامل"
                                   class="font form-control"
                                   name="address" tabindex="5"
                                   value="{{ old('address') }}" required>

                            @if ($errors->has('address'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" tabindex="6" class="font btn btn-block btn3d btn-lg btn-info">ثبت نام
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="flex-center">
                <h6 class="">Coded With <span class="fa fa-heart pulse2"></span> By Arash Hatami</h6>
            </div>
        </div>
    </div>
@endsection
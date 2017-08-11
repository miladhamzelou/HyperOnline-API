<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ایده شو</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/mine.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand my_font" href="http://arash-hatami.ir">ایده شو</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav my_font">
                <li>
                    <a href="{{ url('/') }}">خانه</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right my_font">
                @if (Auth::guest())
                    <li>
                        <a href="{{ url('/login') }}">ورود</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}">ثبت نام</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @if (Auth::user()->can_post())
                                <li>
                                    <a href="{{ url('/new-post') }}">Add new post</a>
                                </li>
                                <li>
                                    <a href="{{ url('/user/'.Auth::id().'/posts') }}">My Posts</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('/user/'.Auth::id()) }}">My Profile</a>
                            </li>
                            <li>
                                <a href="{{ url('/auth/logout') }}">Logout</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    @if (Session::has('message'))
        <div class="flash alert-info">
            <p class="panel-body">
                {{ Session::get('message') }}
            </p>
        </div>
    @endif
    @if ($errors->any())
        <div class='flash alert-danger'>
            <ul class="panel-body">
                @foreach ( $errors->all() as $error )
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel-body">
        @yield('content')
    </div>
</div>
<script src="{{ asset('/js/app.css') }}"></script>
<script src="{{ asset('/js/bootstrap.min.css') }}"></script>
<script src="{{ asset('/js/npm.css') }}"></script>
<script src="{{ asset('/js/jquery.min.css') }}"></script>
<!--[if lt IE 9]>
<script src="{{ asset('/js/respond.min.css') }}"></script>
<script src="{{ asset('/js/html5shiv.min.css') }}"></script>
<![endif]-->
</body>
</html>

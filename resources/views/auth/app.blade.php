<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="DFhB9qBb8hRewxQtoZCtiDQlpBkhSUnU5Dg5IRK6iZA" />
    <title>هایپرآنلاین</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('/auth/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/auth/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/auth/css/form-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('/auth/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/auth/css/iransans.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var bg = '{{ asset('/auth/img/backgrounds/1.png') }}';
    </script>
</head>
<body>
<!-- Top content -->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h2>فروشگاه <strong>هایپرآنلاین</strong></h2>
                </div>
            </div>
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!-- Javascript -->
<script src="{{ asset('auth/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('auth/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('auth/js/jquery.backstretch.min.js') }}"></script>
<script src="{{ asset('auth/js/scripts.js') }}"></script>
<!--[if lt IE 10]>
<script src="{{ asset('auth/js/placeholder.js') }}"></script>
<![endif]-->
</body>
</html>
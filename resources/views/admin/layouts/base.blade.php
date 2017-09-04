<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#3c8dbc"/>
    <title>{{ config('app.name') }} - Admin</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue-light.css') }}">
    @yield('custom-css')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-mini"><b>HO</b></span>
            <span class="logo-lg"><b>Hyper</b>Online</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                {{--<li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success">1</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 4 messages</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle"
                                             alt="User Image">
                                    </div>
                                    <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
            </li>

            <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 10 notifications</li>
                    <li>
                        <ul class="menu">
                            <li><!-- start notification -->
                                <a href="#">
                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                </a>
                            </li>
                            <!-- end notification -->
                        </ul>
                    </li>
                    <li class="footer"><a href="#">View all</a></li>
                </ul>
            </li>


            <!-- Tasks Menu -->
            <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-flag-o"></i>
                    <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 9 tasks</li>
                    <li>
                        <ul class="menu">
                            <li><!-- Task item -->
                                <a href="#">
                                    <!-- Task title and progress text -->
                                    <h3>
                                        Design some buttons
                                        <small class="pull-right">20%</small>
                                    </h3>
                                    <!-- The progress bar -->
                                    <div class="progress xs">
                                        <!-- Change the css width attribute to simulate progress -->
                                        <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                             role="progressbar"
                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <!-- end task item -->
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="#">View all tasks</a>
                    </li>
                </ul>
            </li>--}}
                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle"
                                     alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{ Auth::user()->create_date }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="post"
                                          style="display: none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <hr>
                <li class="header">بخش اصلی</li>
                <!-- Optionally, you can add icons to the links -->
                <li class="my_font"><a href="{{ url('/admin') }}">اطلاعات</a></li>

                <li class="treeview">
                    <a href="#">کالا ها
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/admin/products/create') }}">کالای جدید</a></li>
                        <li><a href="{{ url('/admin/products') }}">لیست کالا ها</a></li>
                        <li><a href="{{ url('/admin/products_inactive') }}">کالاهای تایید نشده</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span>دسته بندی ها</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/admin/categories/create/1') }}">دسته بندی جدید − مرحله ۱</a></li>
                        <li><a href="{{ url('/admin/categories/create/2') }}">دسته بندی جدید − مرحله ۲</a></li>
                        <li><a href="{{ url('/admin/categories/create/3') }}">دسته بندی جدید − مرحله ۳</a></li>
                        <li><a href="{{ url('/admin/categories') }}">لیست دسته بندی ها</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">فروشنده ها
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/admin/authors/create') }}">فروشنده جدید</a></li>
                        <li><a href="{{ url('/admin/authors') }}">لیست فروشنده ها</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">فروشگاه ها
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/admin/sellers/create') }}">فروشگاه جدید</a></li>
                        <li><a href="{{ url('/admin/sellers') }}">لیست فروشگاه ها</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">کاربران
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--                        <li><a href="{{ url('/admin/users/create') }}">کاربر جدید</a></li>--}}
                        <li><a href="{{ url('/admin/users') }}">لیست کاربر ها</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">سفارشات
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--                        <li><a href="{{ url('/admin/orders/create') }}">سفارش جدید</a></li>--}}
                        <li><a href="{{ url('/admin/orders') }}">لیست سفارش ها</a></li>
                        <li><a href="{{ url('/admin/pays') }}">لیست تراکنش ها</a></li>
                    </ul>
                </li>

                <hr>
                <li class="header">تنظیمات</li>
                <li class="my_font"><a href="{{ url('/admin/database') }}">پایگاه داده</a></li>
                <li class="my_font"><a href="{{ url('/admin/support') }}">پشتیبانی</a></li>
                <li class="my_font"><a href="{{ url('/admin/setting') }}">تنظیمات</a></li>
                <li class="treeview">
                    <a href="#">پیام ها
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/admin/messages/sms') }}">ارسال اس ام اس</a></li>
                        <li><a href="{{ url('/admin/messages/push') }}">ارسال پوش</a></li>
                        <li><a href="{{ url('/admin/messages') }}">گزارشات</a></li>
                    </ul>
                </li>

            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="row">
                <div class="pull-left">
                    <div class="input-group">
                        <div class="input-group-btn search-panel">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span id="search_concept">فیلتر</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" style="text-align: center">
                                <li><a href="#products">کالا</a></li>
                                <li><a href="#category1">دسته بندی مرحله اول</a></li>
                                <li><a href="#category2">دسته بندی مرحله دوم</a></li>
                                <li><a href="#category3">دسته بندی مرحله سوم</a></li>
                                <li><a href="#user">کاربران</a></li>
                                <li><a href="#orders">سفارشات</a></li>
                                <li><a href="#comments">نظرات</a></li>
                                <li><a href="#authors">فروشنده ها</a></li>
                                <li><a href="#sellers">فروشگاه ها</a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="search_param" value="all" id="search_param">
                        <input type="text" class="form-control" id="word" name="word"
                               style="text-align: right; direction: rtl"
                               placeholder="عبارت جستجو ...">
                        <span class="input-group-btn" id="search">
                                    <button class="btn btn-default" type="button">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                            </span>
                    </div>
                </div>


                <h1>
                    <span class="pull-right">@yield('title')</span>
                    <br>
                    <br>
                    @if(Session::has('description'))
                        <br>
                        <small>@yield('description')</small>
                    @endif
                </h1>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            @if (Session::has('message'))
                <div class="row">
                    <div class="col-lg-4 col-centered center-block" style="float: none;">
                        <div class="flash alert-success">
                            <p class="panel-body" style="font-size:20px; text-align:center; direction: rtl;">
                                {{ Session::get('message') }}
                            </p>
                        </div>
                    </div>
                </div>
                <br>
            @endif
            @if ($errors->any())
                <div class="row">
                    <div class="col-lg-4 col-centered center-block" style="float: none;">
                        <div class='flash alert-danger'>
                            <ul class="panel-body">
                                @foreach ( $errors->all() as $error )
                                    <li style="font-size:20px; text-align:center; direction: rtl;">
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <br>
            @endif
            @yield('info-box')
            @yield('order-chart')
            @yield('reports')
            @yield('list')
            @yield('add')
            @yield('edit')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Design By : <a href="http://arash-hatami.ir" target="_blank">Arash Hatami</a>
        </div>
        <!-- Default to the left -->
        تمامی حقوق این برنامه مطعلق به شرکت هایپرآنلاین می باشد
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
@yield('custom-js')
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/mine.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
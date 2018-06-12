<?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
<?php include(app_path()."/lang/". $lang); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Registration Management System">
    <meta name="author" content="vdoo.biz">
    <meta name="keyword" content="School, Student, System, Student Management System, School Management System">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Registration Management System</title>

    <!-- Icons -->
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/simple-line-icons.css')}}" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="{{asset('chosen/chosen.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
 
    <script>
        var burl = "{{url('/')}}";
        var asset = "{{asset('img')}}";
        var doc_url = "{{asset('documents/')}}";
    </script>
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">☰</button>
        <a class="navbar-brand" href="#"></a>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item">
                <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
            </li>
            <li class="nav-item px-3 text-primary">
                <img src="{{asset('img/flags/UK.png')}}" alt="" width="32">
            </li>
            <li class="nav-item px-3 text-gray-dark">Branch</li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{asset('profile/'.Auth::user()->photo)}}" class="img-avatar" alt="">
                    <span class="d-md-down-none text-info">{{Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>{{$lb_account}}</strong>
                    </div>
                    <a class="dropdown-item" href="{{url('/user/profile')}}"><i class="fa fa-user text-primary"></i> {{$lb_profile}}</a>
                    <a class="dropdown-item" href="{{url('/user/reset-password')}}"><i class="fa fa-key text-success"></i> {{$lb_reset_password}}</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out text-danger"></i> {{$lb_logout}}</a>
                </div>
            </li>
            <li class="nav-item d-md-down-none">
            </li>

        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        </form>
    </header>
    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}"><i class="fa fa-tachometer text-primary"></i> {{$lb_dashboard}} </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/student')}}" class="nav-link"><i class="fa fa-users text-yellow"></i> {{$lb_student}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/invoice')}}" class="nav-link"><i class="fa fa-money text-danger"></i> Invoice</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/staff')}}" class="nav-link"><i class="fa fa-user text-info"></i> Staff</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/item')}}" class="nav-link"><i class="fa fa-shopping-basket text-pink"></i> item</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle">
                            <i class="fa fa-book text-primary"></i> {{$lb_report}}</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a href="{{url('/report')}}" class="nav-link"><i class="fa fa-list text-yellow"></i> {{$lb_student_list}}</a>
                            </li>
                        </ul>
                    </li>
                    {{--<li class="nav-item">--}}
                        {{--<a href="#" class="nav-link"><i class="fa fa-sign-in text-success"></i> {{$lb_registration}}</a>--}}
                    {{--</li>--}}
                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle">
                            <i class="fa fa-key text-danger"></i> {{$lb_security}}</a>
                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a href="{{url('/user')}}" class="nav-link"><i class="fa fa-user text-yellow"></i> {{$lb_user}}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('/role')}}" class="nav-link"><i class="fa fa-shield text-info"></i> {{$lb_role}}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('/log')}}" class="nav-link"><i class="fa fa-user text-yellow"></i> User Action</a>
                                </li>
                            </ul>

                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa fa-cog text-success"></i> {{$lb_setting}}</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/branch')}}"><i class="fa fa-map-marker"></i> {{$lb_branch}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/class')}}"><i class="fa fa-level-up"></i> {{$lb_class}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/school-year')}}"><i class="fa fa-signal"></i> {{$lb_school_year}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/room')}}"><i class="fa fa-bolt"></i> {{$lb_room}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/subject')}}"><i class="fa fa-book"></i> {{$lb_subject}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/position')}}"><i class="fa fa-level-up"></i> Position</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/shift')}}"><i class="fa fa-clock-o"></i> Shift</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/item-category')}}"><i class="fa fa-sitemap"></i> Item Category</a>
                            </li>
                            <!--
                            <li><a href="{{url('/province')}}" class="nav-link"><i class="fa fa-bookmark"></i> {{$lb_province}}</a></li>
                            <li><a href="{{url('/district')}}" class="nav-link"><i class="fa fa-dot-circle-o"></i> {{$lb_district}}</a></li>
                            <li><a href="{{url('/commune')}}" class="nav-link"><i class="fa fa-adjust"></i> {{$lb_commune}}</a></li>
                            <li><a href="#" class="nav-link"><i class="fa fa-bars"></i> {{$lb_village}}</a></li>
                            -->
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Main content -->
        <main class="main">
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @yield('content')

                </div>

            </div>
        </main>

    </div>
    @yield('modal')
    <footer class="app-footer">
        Copy &copy; {{date('Y')}} by <a href="#">COCD</a>
        <span class="float-right">Powered by <a href="http://vdoo.biz" target="_blank">Vdoo</a>
        </span>
    </footer>
    <!-- Scripts -->
    <script src="{{asset('js/jquery-2.2.3.min.js')}}"></script>
    <!-- Bootstrap and necessary plugins -->
    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('bower_components/tether/dist/js/tether.min.js')}}"></script>
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('bower_components/pace/pace.min.js')}}"></script>
<!-- Plugins and scripts required by all views -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/app1.js') }}"></script>
    @yield('js')
</body>
</html>

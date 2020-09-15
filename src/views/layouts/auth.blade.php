<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="@yield('favicon')">

    <title>@yield('title')</title>

@stack('head')

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{asset('ap/plugins/bootstrap/dist/css/bootstrap.css')}}">

    <!-- Bootstrap extend-->
    <link rel="stylesheet" href="{{asset('ap/css/bootstrap-extend.css')}}">

    <!-- Font Yekan -->
    <link rel="stylesheet" href="{{asset('ap/plugins/font-yekan/css/fontiran.css')}}" type="text/css"/>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('ap/css/master_style.css')}}">

    <!-- Superieur Admin skins -->
    <link rel="stylesheet" href="{{asset('ap/css/skins/_all-skins.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition bg-img rtl" style="background-image: url(@yield('background'));background-position: bottom"
      data-overlay="4">

<div class="container h-p100">
    <div class="row align-items-center justify-content-md-center h-p100">
        <div class="col-12 col-lg-8 col-md-10">
            <div class="row no-gutters justify-content-md-center">
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="content-top-agile h-p100">
                        <h2>@yield('header')</h2>
                        <p class="text-white">@yield('desc')</p>

                        {{--<div class="text-center text-white">
                            <p class="mt-20">- Sign With -</p>
                            <p class="gap-items-2 mb-20">
                                <a class="btn btn-social-icon btn-outline btn-white" href="#"><i
                                        class="fa fa-facebook"></i></a>
                                <a class="btn btn-social-icon btn-outline btn-white" href="#"><i
                                        class="fa fa-twitter"></i></a>
                                <a class="btn btn-social-icon btn-outline btn-white" href="#"><i
                                        class="fa fa-google-plus"></i></a>
                                <a class="btn btn-social-icon btn-outline btn-white" href="#"><i
                                        class="fa fa-instagram"></i></a>
                            </p>
                        </div>--}}

                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="p-40 bg-white content-bottom h-p100">
                        @yield('form')
                        {{--<div class="text-center">
                            <p class="mt-15 mb-0">Don't have an account? <a href="auth_register.html"
                                                                            class="text-info ml-5">Sign Up</a></p>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery 3 -->
<script src="{{asset('ap/plugins/jquery-3.3.1/jquery-3.3.1.js')}}"></script>

<!-- Bootstrap 4.0-->
<script src="{{asset('ap/plugins/bootstrap/dist/js/bootstrap.js')}}"></script>
@stack('script')
</body>
</html>

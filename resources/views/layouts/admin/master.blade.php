<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Lcn store - @yield('title')</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'/>
        <link rel="shortcut icon" href="{{ asset("favicon.ico") }}">
        <link rel="icon" href="{{ asset("favicon.ico") }}">
        <link href="{{ asset("/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/css/ionicons.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/css/admin.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/css/skins/skin-red.min.css")}}" rel="stylesheet" type="text/css" />
        @yield('css')
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
            </script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js">
            </script>
        <![endif]-->
    </head>
    <body class="skin-red">
        <div class="wrapper">
            <!-- Header -->
            @include('layouts.admin.shared.header')
            <!-- Sidebar -->
            @include('layouts.admin.shared.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {{ $page_title or "Page Title" }}
                        <small>
                            {{ $page_description or null }}
                        </small>
                    </h1>
                    <!-- You can dynamically generate breadcrumbs here -->
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">
                                <i class="fa fa-dashboard">
                                </i>
                                Level
                            </a>
                        </li>
                        <li class="active">
                            Here
                        </li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- Footer -->
            @include('layouts.admin.shared.footer')
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <script src="{{ asset("/plugins/jQuery/jQuery-2.2.0.min.js") }}"></script>
        <script src="{{ asset("/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset("/js/app.min.js") }}" type="text/javascript"></script>
        @yield('js')
    </body>
</html>

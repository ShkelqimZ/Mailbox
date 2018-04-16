<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Employee Managment</title>

        <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- AngularJs -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

</head>
<body>
    <div class="wrapper" ng-app="employeesApp" ng-controller="employeesController">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Employee's platform</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="/home"  aria-expanded="false"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;Dashboard</a>
                </li>
                <li id="mailbox">
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" ><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Mailbox&nbsp;&nbsp;@if($numberOfMessages>0)<span class="badge">{{$numberOfMessages}}</span>@endif</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="/inbox"><i class="fa fa-inbox"></i>&nbsp;&nbsp;&nbsp;Inbox&nbsp;&nbsp;@if($numberOfMessages>0)<span class="badge">{{$numberOfMessages}}</span>@endif</a></li>
                        <li><a href="/sent"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;Sent</a></li>
                        <li><a href="/deleted"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Deleted</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users"></i>&nbsp;&nbsp;&nbsp;Employee</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content" style="flex-grow:1;">
            <nav class="navbar navbar-default">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <button type="button" id="navbarCollapse" class="navbar-toggle collapsed navbar-btn" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>





    <script src="{{ asset('js/angular/employees.js') }}"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>
    <script type="text/javascript">
        $("#deleteButton").click(function (event) {
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                return true;
            }
            else {

                event.preventDefault();
                return false;
            }

        });
    </script>
</body>
</html>

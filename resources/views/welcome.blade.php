
<!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Amar Gram</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="theme-color" content="#424242" />
    <link href="{{ asset('logo.png') }}" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/style-main.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/themes/default/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/themes/default/ss-main.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/morris/morris.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/colorpicker/bootstrap-colorpicker.css">

    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/custom_style.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/datepicker/css/bootstrap-datetimepicker.css">
    <!--file dropify-->
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/dropify.min.css">
    <!--file nprogress-->
    <link href="{{ asset('backend') }}/dist/css/nprogress.css" rel="stylesheet">

    <!--print table-->
    <link href="{{ asset('backend') }}/dist/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/dist/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/dist/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!--print table mobile support-->
    <link href="{{ asset('backend') }}/dist/datatables/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/dist/datatables/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <script src="{{ asset('backend') }}/custom/jquery.min.js"></script>
    <script src="{{ asset('backend') }}/dist/js/moment.min.js"></script>
    <script src="{{ asset('backend') }}/datepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="{{ asset('backend') }}/plugins/colorpicker/bootstrap-colorpicker.js"></script>
    <script src="{{ asset('backend') }}/datepicker/date.js"></script>
    <script src="{{ asset('backend') }}/dist/js/jquery-ui.min.js"></script>
    <script src="{{ asset('backend') }}/js/school-custom.js"></script>
    <script src="{{ asset('backend') }}/js/sstoast.js"></script>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('backend') }}/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/fullcalendar/dist/fullcalendar.print.min.css" media="print">


    <script type="text/javascript">
        var baseurl = "http://localhost/EDU/";
        var chk_validate="";

    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and me/
        <!--[if lt IE 9]>
    <script src="http://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Styles -->
{{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div id="app">
    <div class="wrapper">

    <header class="main-header" id="alert" v-show="$route.path === '/' || $route.path ==='/organization/registration' || $route.path === '/forgot'? false : true" style="display: none">
        <router-link to="/admin/dashboard" class="logo">
            <span class="logo-mini">Amar Gram</span>
            <span class="logo-lg"><img src="{{ asset('logo.png') }}" alt="Amar Gram"/></span>
        </router-link>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="col-md-5 col-sm-3 col-xs-5">
                 <router-link to="/admin/dashboard" class="sidebar-session">Amar Gram</router-link>
            </div>
            <div class="col-md-7 col-sm-9 col-xs-7">
                <div class="pull-right">
                    <form class="navbar-form navbar-left search-form" role="search"  action="" method="POST">
                        <input type='hidden' name='ci_csrf_token' value=''/>
                        <div class="input-group" style="padding-top:3px;">
                            <input type="text" name="search_text" class="form-control search-form search-form3" placeholder="Search Resident">
                            <span class="input-group-btn">
                              <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav headertopmenu">
                            <li class="cal15"><a href="#" title="Calendar"><i class="fa fa fa-calendar"></i></a></li>
                            <li class="dropdown">
                                <a href="#" title="Task" class="dropdown-toggle todoicon" data-toggle="dropdown">
                                    <i class="fa fa-check-square-o"></i>
                                </a>
                                <ul class="dropdown-menu menuboxshadow">

                                    <li class="todoview plr10 ssnoti">Today you have 0 pending task.<a href="#" class="pull-right pt0">View All</a></li>
                                    <li>
                                        <ul class="todolist">

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown user-menu">
                                <a class="dropdown-toggle" style="padding: 15px 13px;" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <img src="{{ asset('backend') }}/images/user.jpg" class="topuser-image" alt="User Image">
                                </a>
                                <ul class="dropdown-menu dropdown-user menuboxshadow">
                                    <li>
                                        <div class="sstopuser">
                                            <div class="ssuserleft">
                                                <a href="#"><img src="{{ asset('backend') }}/images/user.jpg" alt="User Image"></a>
                                            </div>

                                            <div class="sstopuser-test">
                                                <h4 style="text-transform: capitalize;">Super Admin</h4>
                                                <h5>Super Admin</h5>
                                                <!-- <div class="sspass pt15"><a class="pull-right" href=""><i class="fa fa-user"></i> My Profile</a></div>   -->
                                            </div>
                                            <div class="divider"></div>
                                            <div class="sspass">
                                                <router-link to="/profile" data-toggle="tooltip" title="" data-original-title="My Profile"><i class="fa fa-user"></i>Profile</router-link>
                                                <router-link class="pull-right" to="/logout"><i class="fa fa-sign-out fa-fw"></i>Logout</router-link>
                                            </div>
                                        </div><!--./sstopuser-->
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar" id="alert2" v-show="$route.path === '/' || $route.path ==='/organization/registration' || $route.path === '/forgot'? false : true" style="display: none">
        <form class="navbar-form navbar-left search-form2" role="search"  action="#" method="POST">
            <input type='hidden' name='ci_csrf_token' value=''/>                            <div class="input-group ">
                <input type="text"  name="search_text" class="form-control search-form" placeholder="Search by name, para, NID etc">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <section class="sidebar" id="sibe-box">
            {{--<ul class="sessionul fixedmenu">--}}
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle drop5" data-toggle="dropdown" href="#" aria-expanded="false">--}}
                        {{--Quick Links <span class="glyphicon glyphicon-th pull-right"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">--}}

                        {{--<li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="http://localhost/EDU/student/search"><i class="fa fa-user-plus"></i>Student Details</a></li>--}}

                        {{--<li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="http://localhost/EDU/admin/mailsms/compose"><i class="fa fa-envelope-o"></i>Send Email / SMS</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            {{--</ul>--}}
            <ul class="sidebar-menu" v-if="loggedInUserType == 'org' ? true : false">

                <li class="treeview ">
                    <router-link to="/dashboard">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </router-link>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>Resident</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class=""><router-link to="/add-people"><i class="fa fa-angle-double-right"></i>Add Resident</router-link></li>
                        <li class=""><router-link to="/peoples"><i class="fa fa-angle-double-right"></i>Resident List</router-link></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <router-link to="/projects">
                        <i class="fa fa-briefcase"></i> <span>Project</span>
                    </router-link>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i> <span>Donation</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>

                    <ul class="treeview-menu">
                        <li class=""><router-link to="/donation/create"><i class="fa fa-angle-double-right"></i>Add Donation</router-link></li>
                        <li class=""><router-link to="/donations"><i class="fa fa-angle-double-right"></i>Donation List</router-link></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <router-link to="/investments">
                        <i class="fa fa-bar-chart"></i> <span>Investment</span>
                    </router-link>
                </li>
                <li class="treeview">
                    <router-link to="/member">
                        <i class="fa fa-list-ul"></i> <span>Membership</span>
                    </router-link>
                </li>

                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>Committee</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><router-link to="/committee"><i class="fa fa-list-ul"></i> <span>Add Committee</span></router-link></li>
                    </ul>

                </li>
                <li class="treeview">
                    <router-link to="/accounts">
                        <i class="fa fa-bank"></i> <span>Accounts</span>
                    </router-link>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-list-alt"></i> <span>Income & Expense</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><router-link to="/income/create"><i class="fa fa-angle-double-right"></i>Add Income</router-link></li>
                        <li><router-link to="/incomes"><i class="fa fa-angle-double-right"></i>Income List</router-link></li>
                        <li><router-link to="/expense/create"><i class="fa fa-angle-double-right"></i>Add Expense</router-link></li>
                        <li><router-link to="/expenses"><i class="fa fa-angle-double-right"></i>Expense List</router-link></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-list-alt"></i> <span>Citizen Charter</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class=""><router-link to="/add-citizen-charter"><i class="fa fa-angle-double-right"></i>Add Citizen Charter</router-link></li>
                        <li class=""><router-link to="/view-citizen-charter"><i class="fa fa-angle-double-right"></i>View Citizen Charter</router-link></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class=""><router-link to="/para"><i class="fa fa-angle-double-right"></i>Para</router-link></li>
                        <li class=""><router-link to="/committee/designation"><i class="fa fa-angle-double-right"></i>Committee Designation</router-link></li>
                        <li class=""><router-link to="/member/type"><i class="fa fa-angle-double-right"></i>Member Type</router-link></li>
                        <li class=""><router-link to="/income-type"><i class="fa fa-angle-double-right"></i>Income Type</router-link></li>
                        <li class=""><router-link to="/expense-type"><i class="fa fa-angle-double-right"></i>Expense Type</router-link></li>
                    </ul>
                </li>
            </ul>
            <ul class="sidebar-menu verttop" v-else>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-user-plus"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class=""><router-link to="/division"><i class="fa fa-angle-double-right"></i>Division</router-link></li>
                        <li class=""><router-link to="/district"><i class="fa fa-angle-double-right"></i>Districts</router-link></li>
                        <li class=""><router-link to="/upozilla"><i class="fa fa-angle-double-right"></i> Upozilla</router-link></li>
                        <li class=""><router-link to="/union"><i class="fa fa-angle-double-right"></i> Union</router-link></li>
                        <li class=""><router-link to="/education-type"><i class="fa fa-angle-double-right"></i> Education Type</router-link></li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <i class="fa fa-user-plus"></i> <span>Organization</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class=""><router-link to="/organization-type"><i class="fa fa-angle-double-right"></i>Organization Type</router-link></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
    <div class="content-wrapper" style="min-height: 946px;">
        <router-view></router-view>
    </div>
    <div id="newEventModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-dialog2 modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Event</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <form role="form"  id="addevent_form" method="post" enctype="multipart/form-data" action="">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Event Title</label>
                                <input class="form-control" name="title" id="input-field">
                                <span class="text-danger"></span>

                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea name="description" class="form-control" id="desc-field"></textarea></div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Event Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" autocomplete="off" name="event_dates" class="form-control pull-right" id="date-field">
                                </div>
                                <!-- <input class="form-control" type="text" autocomplete="off"  name="event_dates" id="date-field"> --></div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Event Color</label>
                                <input type="hidden" name="eventcolor" autocomplete="off" id="eventcolor" class="form-control">
                            </div>
                            <div class="form-group col-md-12">

                                <div class="cpicker-wrapper"><div class='calendar-cpicker cpicker cpicker-big' data-color='#03a9f4' style='background:#03a9f4;border:1px solid #03a9f4; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#c53da9' style='background:#c53da9;border:1px solid #c53da9; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#757575' style='background:#757575;border:1px solid #757575; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#8e24aa' style='background:#8e24aa;border:1px solid #8e24aa; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#d81b60' style='background:#d81b60;border:1px solid #d81b60; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#7cb342' style='background:#7cb342;border:1px solid #7cb342; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#fb8c00' style='background:#fb8c00;border:1px solid #fb8c00; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#fb3b3b' style='background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px'></div></div>                        </div>

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Event Type</label>
                                <br/>
                                <label class="radio-inline">

                                    <input type="radio" name="event_type" value="public" id="public">Public                            </label>
                                <label class="radio-inline">

                                    <input type="radio" name="event_type" value="private" checked id="private">Private                            </label>
                                <label class="radio-inline">

                                    <input type="radio" name="event_type" value="sameforall" id="public">All Super Admin                            </label>
                                <label class="radio-inline">

                                    <input type="radio" name="event_type" value="protected" id="public">Protected                            </label> </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="submit" class="btn btn-primary submit_addevent pull-right" value="Save"></div> </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="viewEventModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-dialog2 modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">View Event</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <form role="form"   method="post" id="updateevent_form"  enctype="multipart/form-data" action="" >
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">EventTitle</label>
                                <input class="form-control" name="title" placeholder="Event Title" id="event_title">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea name="description" class="form-control" placeholder="Event Description" id="event_desc"></textarea></div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">EventDate</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" autocomplete="off" name="eventdates" class="form-control pull-right" id="eventdates">
                                </div>
                                <!-- <input class="form-control" type="text" autocomplete="off" name="eventdates" placeholder="Event Dates" id="eventdates"> --></div>
                            <input type="hidden" name="eventid" id="eventid">
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">EventColor</label>
                                <input type="hidden" name="eventcolor" autocomplete="off" placeholder="Event Color" id="event_color" class="form-control">
                            </div>
                            <div class="form-group col-md-12">

                                <div class="cpicker-wrapper selectevent"><div id=03a9f4 class='calendar-cpicker cpicker cpicker-big' data-color='#03a9f4' style='background:#03a9f4;border:1px solid #03a9f4; border-radius:100px'></div><div id=c53da9 class='calendar-cpicker cpicker cpicker-small' data-color='#c53da9' style='background:#c53da9;border:1px solid #c53da9; border-radius:100px'></div><div id=757575 class='calendar-cpicker cpicker cpicker-small' data-color='#757575' style='background:#757575;border:1px solid #757575; border-radius:100px'></div><div id=8e24aa class='calendar-cpicker cpicker cpicker-small' data-color='#8e24aa' style='background:#8e24aa;border:1px solid #8e24aa; border-radius:100px'></div><div id=d81b60 class='calendar-cpicker cpicker cpicker-small' data-color='#d81b60' style='background:#d81b60;border:1px solid #d81b60; border-radius:100px'></div><div id=7cb342 class='calendar-cpicker cpicker cpicker-small' data-color='#7cb342' style='background:#7cb342;border:1px solid #7cb342; border-radius:100px'></div><div id=fb8c00 class='calendar-cpicker cpicker cpicker-small' data-color='#fb8c00' style='background:#fb8c00;border:1px solid #fb8c00; border-radius:100px'></div><div id=fb3b3b class='calendar-cpicker cpicker cpicker-small' data-color='#fb3b3b' style='background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px'></div></div>                        </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">EventType</label>
                                <label class="radio-inline">

                                    <input type="radio" name="eventtype" value="public" id="public">Public                            </label>
                                <label class="radio-inline">

                                    <input type="radio" name="eventtype" value="private" id="private">Private
                                </label>
                                <label class="radio-inline">

                                    <input type="radio" name="eventtype" value="sameforall" id="public">All Super Admin                            </label>
                                <label class="radio-inline">

                                    <input type="radio" name="eventtype" value="protected" id="public">Protected
                                </label>
                            </div>

                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">

                                <input type="submit" class="btn btn-primary submit_update pull-right" value="Save">
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <input type="button" id="delete_event" class="btn btn-primary submit_delete pull-right" value="Delete">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <footer class="main-footer" v-show="$route.path === '/' || $route.path ==='/organization/registration' || $route.path === '/forgot'? false : true" style="display: none">
        <span style="display: inline-block;">
            Made With <i class="fa fa-heart"></i> by <a href="javascript:void(0)" style="display: inline-block;">Team Undefined</a>
        </span>
    </footer>
    <div class="control-sidebar-bg"></div>
</div>
</div>

<script src="{{ asset('backend') }}/dist/js/moment.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<link href="{{ asset('backend') }}/toast-alert/toastr.css" rel="stylesheet"/>
<script src="{{ asset('backend') }}/toast-alert/toastr.js"></script>
<script src="{{ asset('backend') }}/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/select2.min.css">
<script src="{{ asset('backend') }}/plugins/select2/select2.full.min.js"></script>
<script src="{{ asset('backend') }}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ asset('backend') }}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ asset('backend') }}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="{{ asset('backend') }}/dist/js/moment.min.js"></script>
<script src="{{ asset('backend') }}/plugins/daterangepicker/daterangepicker.js"></script>
<script src="{{ asset('backend') }}/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="{{ asset('backend') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="{{ asset('backend') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('backend') }}/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            // autoclose: true
        });
        $(".studentsidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('.studentsideclose, .overlay').on('click', function () {
            $('.studentsidebar').removeClass('active');
            $('.overlay').fadeOut();
        });

        $('#sidebarCollapse').on('click', function () {
            $('.studentsidebar').addClass('active');
            $('.overlay').fadeIn();
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>


<script src="{{ asset('backend') }}/plugins/iCheck/icheck.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="{{ asset('backend') }}/plugins/chartjs/Chart.min.js"></script>
<script src="{{ asset('backend') }}/plugins/fastclick/fastclick.min.js"></script>
<!-- <script type="text/javascript" src="backend/dist/js/bootstrap-filestyle.min.js"></script> -->
<script src="{{ asset('backend') }}/dist/js/app.min.js"></script>

<!--nprogress-->
<script src="{{ asset('backend') }}/dist/js/nprogress.js"></script>
<!--file dropify-->
<script src="{{ asset('backend') }}/dist/js/dropify.min.js"></script>


<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/buttons.colVis.min.js" ></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/dataTables.responsive.min.js" ></script>
<script type="text/javascript" src="{{ asset('backend') }}/dist/datatables/js/ss.custom.js" ></script>


</body>
</html>
<!-- jQuery 3 -->
<!--script src="{{ asset('backend') }}/dist/js/pages 2.js"></script-->
<script src="{{ asset('backend') }}/fullcalendar/dist/fullcalendar.min.js"></script>



<script type="text/javascript">
    $(document).ready(function () {
        $("#date-field").daterangepicker({timePicker: true, timePickerIncrement: 5, locale: {
            format: 'MM/DD/YYYY hh:mm A'
        }});

        $('.select2').select2({
            placeholder: 'Select an option'
        });

    });

    function datepic() {
        $("#date-field").daterangepicker();
    }


    $("body").on('click', '.cpicker', function () {
        var color = $(this).data('color');
        // Clicked on the same selected color
        if ($(this).hasClass('cpicker-big')) {
            return false;
        }

        $(this).parents('.cpicker-wrapper').find('.cpicker-big').removeClass('cpicker-big').addClass('cpicker-small');
        $(this).removeClass('cpicker-small', 'fast').addClass('cpicker-big', 'fast');
        if ($(this).hasClass('kanban-cpicker')) {
            $(this).parents('.panel-heading-bg').css('background', color);
            $(this).parents('.panel-heading-bg').css('border', '1px solid ' + color);
        } else if ($(this).hasClass('calendar-cpicker')) {
            $("body").find('input[name="eventcolor"]').val(color);
        }
    });

</script>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{$title or ''}}</title>
    <meta name="description" content="{{$title or ''}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="{{asset('public/assets/images/favicon.png')}}" type="image/x-icon">
    

    <!--Basic Styles-->
    <link href="{{url(asset('public/assets/css/mycss.css'))}}" rel="stylesheet" />
    <link href="{{url(asset('public/assets/css/bootstrap.min.css'))}}" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="{{url(asset('public/assets/css/font-awesome.min.css'))}}" rel="stylesheet" />
    <link href="{{url(asset('public/assets/css/weather-icons.min.css'))}}" rel="stylesheet" />
    <!--Fonts-->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300"
    rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="{{url(asset('public/assets/css/beyond.min.css'))}}" rel="stylesheet" />
    <link href="{{url(asset('public/assets/css/demo.min.css'))}}" rel="stylesheet" />
    <link href="{{url(asset('public/assets/css/typicons.min.css'))}}" rel="stylesheet" />
    <link href="{{url(asset('public/assets/css/animate.min.css'))}}" rel="stylesheet" />    
    
    
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    <link href="{{url(asset('public/assets/css/dataTables.bootstrap.css'))}}" rel="stylesheet" />   
    <script src="{{url(asset('public/assets/js/skins.js'))}}"></script>
    <link href="{!!asset('public/assets/css/jquery-ui.css')!!}" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    @yield('css')
</head>
<body>
    <!-- Loading Container -->
    <div class="loading-container">
        <div class="loader"></div>
    </div>
    <!--  /Loading Container -->
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="{{url()}}" class="navbar-brand">
                        <small>
                            <img src="{{url(asset('public/assets/img/logo.png'))}}" alt="" />
                        </small>
                    </a>
                </div>
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings -->
                <div class="navbar-header pull-right">
                    <div class="navbar-account">
                        <ul class="account-area">                            
                            <li>
                                <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                    <div class="avatar" title="View your public profile">
                                        <img src="{{asset('public/assets/images/'.getImage(Auth::user()->id))}}"  onerror="this.src = '{!!asset("public/assets/images/default.jpg")!!}'" alt="">
                                    </div>
                                    <section>
                                        <h2><span class="profile"><span>@if(Auth::user()->name == "") {!!Auth::user()->email!!} @else {!!Auth::user()->name!!} @endif</span></span></h2>
                                    </section>
                                </a>
                                <!--Login Area Dropdown-->
                                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area" style="min-width:186px;">
                                    <li class="username"><a>@if(Auth::user()->name == "") {{"No Name"}} @else {!!Auth::user()->name!!} @endif</a></li>
                                    <li class="email"><a>{!!Auth::user()->email!!}</a></li>
                                    <!--Avatar Area-->
                                    <li>
                                        <div class="avatar-area">
                                            <img src="{!!url('public/assets/images/'.getImage(Auth::user()->id))!!}" onerror="this.src = '{!!asset("public/assets/images/default.jpg")!!}'" alt="" class="avatar">                                            
                                        </div>
                                    </li>
                                    <!--Avatar Area-->
                                    <li class="edit">
                                        <a href="{{url('admin/profile')}}" class="pull-left">Profile</a>
                                        <a href="{{url('admin/changepassword')}}" class="pull-right">Change Password</a>
                                    </li>
                                    <!--Theme Selector Area-->
                                    <li class="theme-area">
                                        <ul class="colorpicker" id="skin-changer">
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#5DB2FF;" rel="{{url(asset('public/assets/css/skins/blue.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#2dc3e8;" rel="{{url(asset('public/assets/css/skins/azure.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#03B3B2;" rel="{{url(asset('public/assets/css/skins/teal.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#53a93f;" rel="{{url(asset('public/assets/css/skins/green.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#FF8F32;" rel="{{url(asset('public/assets/css/skins/orange.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#cc324b;" rel="{{url(asset('public/assets/css/skins/pink.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#AC193D;" rel="{{url(asset('public/assets/css/skins/darkred.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#8C0095;" rel="{{url(asset('public/assets/css/skins/purple.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#0072C6;" rel="{{url(asset('public/assets/css/skins/darkblue.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#585858;" rel="{{url(asset('public/assets/css/skins/gray.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#474544;" rel="{{url(asset('public/assets/css/skins/black.min.css'))}}"></a></li>
                                            <li><a class="colorpick-btn" href="javascript:void(0)" style="background-color:#001940;" rel="{{url(asset('public/assets/css/skins/deepblue.min.css'))}}"></a></li>
                                        </ul>
                                    </li>
                                    <!--/Theme Selector Area-->
                                    <li class="dropdown-footer">
                                        <a href="{{url('auth/logout')}}">
                                            Sign out
                                        </a>
                                    </li>
                                </ul>
                                <!--/Login Area Dropdown-->
                            </li>
                            <!-- /Account Area -->
                            <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                            <!-- Settings -->
                        </ul><div class="setting">
                        <a id="btn-setting" title="Setting" href="#">
                            <i class="icon glyphicon glyphicon-cog"></i>
                        </a>
                    </div><div class="setting-container">
                    <label>
                        <input type="checkbox" id="checkbox_fixednavbar">
                        <span class="text">Fixed Navbar</span>
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_fixedsidebar">
                        <span class="text">Fixed SideBar</span>
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_fixedbreadcrumbs">
                        <span class="text">Fixed BreadCrumbs</span>
                    </label>
                    <label>
                        <input type="checkbox" id="checkbox_fixedheader">
                        <span class="text">Fixed Header</span>
                    </label>
                </div>
                <!-- Settings -->
            </div>
        </div>
        <!-- /Account Area and Settings -->
    </div>
</div>
</div>
<!-- /Navbar -->
<!-- Main Container -->
<div class="main-container container-fluid">
    <!-- Page Container -->
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar" id="sidebar">                
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu">
                <!--Dashboard-->
                <li>
                    <a href="{{url()}}">
                        <i class="menu-icon glyphicon glyphicon-home"></i>
                        <span class="menu-text"> Dashboard </span>
                    </a>
                </li>                    
                <!--Department-->
                @if(Auth::user()->role_id==4)
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-list"></i>
                        <span class="menu-text"> Departments </span>

                        <i class="menu-expand"></i>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{url('admin/department/create')}}">
                                <span class="menu-text">Add</span>
                            </a>
                        </li>                            
                        <li>
                            <a href="{{url('admin/department')}}">
                                <span class="menu-text">List</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif
                <!--Level-->
                @if(Auth::user()->role_id==4)
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-tasks"></i>
                        <span class="menu-text"> Level </span>

                        <i class="menu-expand"></i>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{url('admin/level/create')}}">
                                <span class="menu-text">Add</span>
                            </a>
                        </li>                            
                        <li>
                            <a href="{{url('admin/level')}}">
                                <span class="menu-text">List</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif                
                <!-- Staff -->
                @if(Auth::user()->role_id==2||Auth::user()->role_id==4)
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-user"></i>
                        <span class="menu-text"> Staff </span>

                        <i class="menu-expand"></i>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{url('admin/staff/create')}}">
                                <span class="menu-text">Add</span>
                            </a>
                        </li>                            
                        <li>
                            <a href="{{url('admin/staff')}}">
                                <span class="menu-text">List</span>
                            </a>
                        </li>

                    </ul>                       
                </li>               
                @endif
                <!-- Teams -->
                @if(Auth::user()->role_id>2)
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text"> Teams </span>

                        <i class="menu-expand"></i>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="{{url('admin/team/manager')}}">
                                <i class="fa fa-asterisk"></i>
                                <span class="menu-text">Managers</span>
                            </a>
                        </li>                            
                        <li>
                            <a href="{{url('admin/team/leader')}}">
                                <i class="fa fa-gears"></i>
                                <span class="menu-text">Leaders</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif
                <!-- Review -->
                @if(Auth::user()->role_id<3)
                <li>
                    <a href="{{url('admin/review')}}" class="menu-dropdown">
                        <span class="typcn typcn-social-instagram"></span>
                        <span class="menu-text"> My Reviews </span>
                    </a>                    
                </li>               
                @endif
                <li>                    
                    <a class="title">You're a {{Auth::user()->role->name}} @if(Auth::user()->department)in {{Auth::user()->department->name}}@endif</a>                                                                                             
                </li>                              
            </ul>
            <!-- /Sidebar Menu -->
        </div>
        <!-- /Page Sidebar -->
       
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                @yield('crumb')
                <span class="pull-right" style="margin-right:20px"><a class="btn btn-info" href="{{url('admin/help')}}">Help <i class="fa fa-warning right"></i></a></span>
            </div>
            <!-- /Page Breadcrumb -->
            <!-- Page Header -->
            <div class="page-header position-relative">
                <div class="header-title">
                    <h1>
                        {{$title or ''}}
                    </h1>
                </div>
                <!--Header Buttons-->
                <div class="header-buttons">
                    <a class="sidebar-toggler" href="#">
                        <i class="fa fa-arrows-h"></i>
                    </a>
                    <a class="refresh" id="refresh-toggler" href="">
                        <i class="glyphicon glyphicon-refresh"></i>
                    </a>
                    <a class="fullscreen" id="fullscreen-toggler" href="#">
                        <i class="glyphicon glyphicon-fullscreen"></i>
                    </a>
                </div>
                <!--Header Buttons End-->
            </div>
            <!-- /Page Header -->
            <!-- Page Body -->
            <div class="page-body">
                <!-- Your Content Goes Here -->
                @yield('content')
            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Container -->
    <!-- Main Container -->

</div>

<!--Basic Scripts-->

<script src="{{url(asset('public/assets/js/jquery.min.js'))}}"></script>
<script src="{{url(asset('public/assets/js/bootstrap.min.js'))}}"></script>
<script src="{{url(asset('public/assets/js/slimscroll/jquery.slimscroll.min.js'))}}"></script>

<!--Beyond Scripts-->
<script src="{{url(asset('public/assets/js/beyond.min.js'))}}"></script>

<!--Page Related Scripts-->
<script src="{{url(asset('public/assets/js/datatable/jquery.dataTables.min.js'))}}"></script>    
<script src="{{url(asset('public/assets/js/datatable/ZeroClipboard.js'))}}"></script>
<script src="{{url(asset('public/assets/js/datatable/dataTables.tableTools.min.js'))}}"></script>
<script src="{{url(asset('public/assets/js/datatable/dataTables.bootstrap.min.js'))}}"></script>
<script src="{!!asset('public/assets/js/jquery-ui.js')!!}"></script>
<script src="{{url(asset('public/assets/js/myscript.js'))}}"></script>
<script src="{{url(asset('public/assets/js/bootbox/bootbox.js'))}}"></script>
@yield('script')
<script>
    $('a.delete').click(function (e) {
        e.preventDefault();

        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                //
                 // $(this).closest('form').submit();
                 document.location.href = (e.target.href);
             }else return;
         });
    });            
    $("div.alert").delay(15000).slideUp();

</script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#table').DataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        });
    });
</script>
<script>
  $(function() {     
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',showAnim: 'drop', changeMonth: true,
      changeYear: true,yearRange: '1990:2015'});
});
</script>
</body>
<!--  /Body -->
</html>

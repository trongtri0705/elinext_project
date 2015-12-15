<!DOCTYPE html>
<!--
BeyondAdmin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 1.4
Purchase: http://wrapbootstrap.com
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title>{{$title or ''}}</title>

    <meta name="description" content="Error 404 - Page Not Found" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="{{url('public/assets/images/favicon.png')}}" type="image/x-icon">

    <!--Basic Styles-->
    <link href="{{url('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="{{url('public/assets/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{url('public/assets/css/weather-icons.min.css')}}" rel="stylesheet" />

    <!--Fonts-->
    <link href="{{url('public/assets/css/google-font.css')}}" rel="stylesheet" />

    <!--Beyond styles-->
    <link id="beyond-link" href="{{url('public/assets/css/beyond.min.css')}}" rel="stylesheet" />
    <link href="{{url('public/assets/css/demo.min.css')}}" rel="stylesheet" />
    <link href="{{url('public/assets/css/animate.min.css')}}" rel="stylesheet" />
    <link id="skin-link" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="{{url('public/assets/js/skins.js')}}"></script>
</head>
<!--Head Ends-->
<!--Body-->
@yield('content')
<script src="{{url(asset('public/assets/js/jquery.min.js'))}}"></script>
    <script src="{{url(asset('public/assets/js/bootstrap.min.js'))}}"></script>
    <script src="{{url(asset('public/assets/js/slimscroll/jquery.slimscroll.min.js'))}}"></script>

    <!--Beyond Scripts-->
    <script src="{{url(asset('public/assets/js/beyond.js'))}}"></script>

    
</body>
<!--Body Ends-->
</html>

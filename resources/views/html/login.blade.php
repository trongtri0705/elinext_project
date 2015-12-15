@extends('html.morepage.layout')
@section('content')
<body>
    <form role="form" action="" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token()!!}" />    
        <div class="login-container animated fadeInDown">
            <div class="loginbox bg-white">
                @include('html.block.message')                 
                <div class="loginbox-title">SIGN IN</div>
                <div class="loginbox-social">
                    <div class="social-title ">Connect with Your Social Accounts</div>
                    <div class="social-buttons">
                        <a href="" class="button-facebook">
                            <i class="social-icon fa fa-facebook"></i>
                        </a>
                        <a href="" class="button-twitter">
                            <i class="social-icon fa fa-twitter"></i>
                        </a>
                        <a href="" class="button-google">
                            <i class="social-icon fa fa-google-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="loginbox-or">
                    <div class="or-line"></div>
                    <div class="or">OR</div>
                </div>
                <div class="loginbox-textbox">
                    <input class="form-control" placeholder="E-mail" name="email"  value="{{ old('email') }}" type="email" autofocus>
                </div>
                <div class="loginbox-textbox">
                    <input class="form-control" placeholder="Password" name="password" type="password">
                </div>
                <div class="loginbox-forgot">
                    <a href="">Forgot Password?</a>
                </div>
                <div class="loginbox-textbox">
                    <div class="checkbox">
                        <label>
                        <input name="remember" type="checkbox" class="colored-primary" checked="checked">
                            <span class="text darkgray">Remember me</span>
                        </label>
                    </div>
                </div>
                <div class="loginbox-submit">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </div>        
        </div>
    </form>
    <!--Basic Scripts-->
    @stop
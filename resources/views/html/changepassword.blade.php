@extends('html.master')
@section('content')
<div class="container">
    @include('html.block.message')
    <p>Please fill out the following fields to change password :</p>    
    <form id="changepassword-form" class="form-horizontal" action="{{url('admin/changepassword')}}" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token()!!}" />    
        <div class="form-group field-changepassword-oldpass required">
            <label class="col-lg-2 control-label" for="changepassword-oldpass">Old Password</label>
            <div class="col-lg-3">
                <input type="password" id="changepassword-oldpass" class="form-control" name="txtOldPass" placeholder="Old Password">
            </div>
            <div class="col-lg-5">
                <p class="help-block help-block-error"></p>
            </div>
        </div>        
        <div class="form-group field-changepassword-newpass required">
            <label class="col-lg-2 control-label" for="changepassword-newpass">New Password</label>
            <div class="col-lg-3">
                <input type="password" id="changepassword-newpass" class="form-control" name="txtPass" placeholder="New Password">
            </div>
            <div class="col-lg-5">
                <p class="help-block help-block-error"></p>
            </div>
        </div>        
        <div class="form-group field-changepassword-repeatnewpass required">
            <label class="col-lg-2 control-label" for="changepassword-repeatnewpass">Repeat New Password</label>
            <div class="col-lg-3">
                <input type="password" id="changepassword-repeatnewpass" class="form-control" name="txtRePass" placeholder="Repeat New Password">
            </div>
            <div class="col-lg-5">
                <p class="help-block help-block-error"></p>
            </div>
        </div>        
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-11">
                <button type="submit" class="btn btn-primary">Change password</button>                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                <a class="btn btn-danger" href="{{url()}}">Cancel</a>            
            </div>
        </div>
    </form>    
</div>
@stop                            
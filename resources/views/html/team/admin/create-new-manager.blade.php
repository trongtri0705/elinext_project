@extends('html.master')
{{-- Content --}}
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li>
        <a class="active">{{$title}}</a>
    </li>    
    @stop
    @section('content')     
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general" data-toggle="tab"></a></li>
    </ul>
    {!! Form::open(array('url' => URL::to('admin/create-new-manager'), 'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
  
    <!-- Tabs Content -->
    <div class="tab-content">
        <div class="col-lg-12">
            @include('html.block.message')
        </div>  
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">        
            <div class="form-group">        
                <label>Email</label><sup class="danger"><b>*</b></sup>
                <span class="input-icon">
                    <input type="email" class="form-control" name="txtEmail" placeholder="Please Enter Email" value="{!! old('txtEmail',isset($staff)? $staff['email'] :null)!!}"/>
                    <i class="fa fa-envelope info circular"></i>
                </span>
                @if($errors->has('txtEmail'))<span class='help-block'>{{$errors->first('txtEmail', ':message')}}</span>@endif            
            </div>                        
            <div class="form-group">
                <label>Password</label><sup class="danger"><b>*</b></sup>
                <span class="input-icon">
                    <input type="password" class="form-control" name="txtPass" placeholder="Please Enter Password"/>
                    <i class="fa fa-qrcode success circular"></i>
                </span>                    
                @if($errors->has('txtPass'))<span class='help-block'>{{$errors->first('txtPass', ':message')}}</span>@endif
            </div>                
            <div class="form-group">
                <label>Retype Password</label><sup class="danger"><b>*</b></sup>                  
                <span class="input-icon">
                    <input type="password" class="form-control" name="txtRePass" placeholder="Please Retype Password"/>
                    <i class="fa fa-qrcode darkgrey circular"></i>
                </span>
                @if($errors->has('txtRePass'))<span class='help-block'>{{$errors->first('txtRePass', ':message')}}</span>@endif
            </div>           
            <div class="form-group">
                <label>Name</label><sup class="danger"><b>*</b></sup>
                <span class="input-icon">
                    <input class="form-control" name="txtName" placeholder="Please Enter Staff Name" value="{!! old('txtName',isset($staff)? $staff['name'] :null)!!}"/>
                    <i class="fa fa-user darkorange circular"></i>
                </span>
                @if($errors->has('txtName'))<span class='help-block'>{{$errors->first('txtName', ':message')}}</span>@endif
            </div>
            <div class="form-group">
                <label>Department</label><sup class="danger"><b>*</b></sup>
                <span class="input-icon">                    
                    <select class="selectpicker" name="sltDepartment">
                        <option value="">Choose a department...</option>                       
                        @foreach($department as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach   
                    </select>
                </span>
                @if($errors->has('sltDepartment'))<span class='help-block'>{{$errors->first('sltDepartment', ':message')}}</span>@endif
            </div> 
            <div class="form-group">
                <label>Role</label><sup class="danger"><b>*</b></sup>
                <span class="input-icon">                    
                    <select class="selectpicker" name="sltRole" id="role">
                        <option value="3">Manager</option>                                                                                                                                                                                                                                                                                                  
                    </select>
                </span>
                @if($errors->has('sltRole'))<span class='help-block'>{{$errors->first('sltRole', ':message')}}</span>@endif
            </div>
            <div class="form-group">
                <label>Level</label><sup class="danger"><b>*</b></sup>
                <div style="border:1px solid #d5d5d5; padding-left:20px;" class="form-group" id="level">                        
                </div>
                @if($errors->has('rdbLevel'))<span class='help-block'>{{$errors->first('rdbLevel', ':message')}}</span>@endif
            </div>                            
            <div class="row">
                <div class="form-group col-lg-6 col-sm-6 col-xs-12">
                    <label>Phone</label>
                    <span class="input-icon">    
                        <input class="form-control" name="txtPhone" placeholder="Please Enter Phone" type='tel' pattern='\d{10,11}' />
                        <span>format: 0123456789(0)</span>
                        <i class="fa fa-phone primary circular"></i>
                    </span>
                    @if($errors->has('txtPhone'))<span class='help-block'>{{$errors->first('txtPhone', ':message')}}</span>@endif
                </div> 
                <div class="form-group col-lg-6 col-sm-6 col-xs-12">
                    <label>Birth Day</label><sup class="danger"><b>*</b></sup>
                    <span class="input-icon">
                        <input class="form-control" type="text" id="datepicker" name="txtBirth" size="20" placeholder="Please Enter Birthday "/>            
                        <i class="fa fa-birthday-cake purple circular"></i>
                    </span>
                    @if($errors->has('txtBirth'))<span class='help-block'>{{$errors->first('txtBirth', ':message')}}</span>@endif
                </div> 
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button onclick="javascript:window.location.href='{{url('admin/staff')}}'; return false;" type="reset" class="btn btn-sm btn-warning">
                <span class="glyphicon glyphicon-remove-circle"></span> Cancel
            </button>
            <button type="submit" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-ok-circle"></span>                
                Create                
            </button>
        </div>
    </div>
</form>
@stop
@section('script')
<script>
    $(document).ready(function(){ 
        $.get("{{url('admin/staff/getlevel/')}}"+"/" + $('#role').val(), function(data) {                        
            $("#level").html(data);
        });            
        $('#role').change(function(){
            $.get("{{url('admin/staff/getlevel/')}}"+"/" + $(this).val(), function(data) {                        
                $("#level").html(data);
            }); 
        });
    })
</script>
@endsection
@extends('html.master')
{{-- Content --}}
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li>
        <a href="{{url('admin/department')}}">Department</a>
    </li>
    <li class="active">@if (isset($department))
        Edit
        @else
        Create
        @endif</li>
    </ul>
    @stop
    @section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general" data-toggle="tab"></a></li>
    </ul>
    <!-- ./ tabs -->
    @if (isset($department))
    {!! Form::model($department, array('url' => URL::to('admin/department') . '/' . $department->id, 'method' => 'put','id'=>'fupload', 'class' => 'bf', 'files'=> true)) !!}
    @else
    {!! Form::open(array('url' => URL::to('admin/department'), 'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
    @endif
    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">

            <div class="form-group">
                <label>Name</label><sup class="danger">*</sup>
                <span class="input-icon">
                    <input class="form-control" name="txtName" placeholder="Please Enter Department Name" value="{!! old('txtName',isset($department)? $department['name'] :null)!!}" autofocus />
                    <i class="fa fa-home sky circular"></i>
                </span>
                @if($errors->has('txtName'))<span class='help-block'>{{$errors->first('txtName', ':message')}}</span>@endif            
            </div>     
            <!-- ./ general tab -->
        </div>
        <!-- ./ tabs content -->
    </div>

    <!-- Form Actions -->

    <div class="form-group">
        <div class="col-md-12">
            <button onclick="javascript:window.location.href='{{url('admin/department')}}'; return false;" type="reset" class="btn btn-sm btn-warning">
                <span class="glyphicon glyphicon-remove-circle"></span> Cancel
            </button>
            <button type="submit" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-ok-circle"></span>
                @if (isset($department))
                Edit
                @else
                Create
                @endif
            </button>
        </div>
    </div>
    <!-- ./ form actions -->

</form>
@stop

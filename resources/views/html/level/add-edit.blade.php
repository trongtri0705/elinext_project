@extends('html.master')
{{-- Content --}}
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li>
        <a href="{{url('admin/level')}}">Level</a>
    </li>
    <li class="active">@if (isset($level))
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
    @if (isset($level))
    {!! Form::model($level, array('url' => URL::to('admin/level') . '/' . $level->id, 'method' => 'put','id'=>'fupload', 'class' => 'bf', 'files'=> true)) !!}
    @else
    {!! Form::open(array('url' => URL::to('admin/level'), 'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
    @endif
    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">
            <div class="form-group">
            <label>Name</label><sup class="danger">*</sup>@if(!isset($level))<span ><i class="primary"><h6>(You can add more one level in the same time)</h6></i></span>@endif
                <input class="form-control" name="txtName" type="text" @if(!isset($level)){{'data-role=tagsinput'}}@endif placeholder="Add levels" value="{!! old('txtName',isset($level)? $level['name'] :null)!!}" autofocus/>
                @if($errors->has('txtName'))<span class='help-block'>{{$errors->first('txtName', ':message')}}</span>@endif            
            </div>
            <div class="form-group">
                <label>Role</label><sup class="danger">*</sup>
                <select id="e1" name="sltRole" style="width: 100%;;">
                    <option value="" />Select Role                                            
                    @foreach($role as $item)
                        <option value="{{$item->id}}" @if(isset($level) && $level->id==$item->id){{'selected=selected'}}@endif/>{{$item->name}}                                            
                    @endforeach
                    </select>
                    @if($errors->has('sltRole'))<span class='help-block'>{{$errors->first('sltRole', ':message')}}</span>@endif            
                </div>     
                <!-- ./ general tab -->
            </div>
            <!-- ./ tabs content -->
        </div>

        <!-- Form Actions -->

        <div class="form-group">
            <div class="col-md-12">
                <button onclick="javascript:window.location.href='{{url('admin/level')}}'; return false;" type="reset" class="btn btn-sm btn-warning">
                    <span class="glyphicon glyphicon-remove-circle"></span> Cancel
                </button>
                <button type="submit" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    @if (isset($level))
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
    @section('script')
    <script src="{{url(asset('public/assets/js/tagsinput/bootstrap-tagsinput.js'))}}"></script>
    <script src="{{url(asset('public/assets/js/select2/select2.js'))}}"></script>
    <script type="text/javascript">
        $("#e1").select2();
    </script>
    @stop

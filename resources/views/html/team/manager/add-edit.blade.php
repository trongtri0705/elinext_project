@extends('html.master')
{{-- Content --}}
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li>
        <a href="{{url('admin/staff')}}">{{$title}}</a>
    </li>
    <li class="active">
        @if (isset($staff))
        Edit
        @else
        Create
        @endif
    </li>
</ul>
@stop
@section('content')

<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab"></a></li>
</ul>
<!-- ./ tabs -->
@if (isset($staff))
{!! Form::model($staff, array('url' => URL::to('admin/team/manager') . '/' . $staff->id, 'method' => 'put','id'=>'fupload', 'class' => 'bf', 'files'=> true)) !!}
@elseif(isset($team))
{!! Form::open(array('url' => URL::to('admin/team/manager/add/'.$team->id), 'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
@else
{!! Form::open(array('url' => URL::to('admin/team/manager'), 'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
@endif
<input type="hidden" name="_token" value="{!! csrf_token()!!}" />
<!-- Tabs Content -->
<div class="tab-content">
    <div class="tab-pane active" id="tab-general"> 
        @if(!isset($team))        
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" name="txtName" placeholder="Please Enter Team's Name" value="{!! old('txtName',isset($staff)? $staff['name'] :null)!!}" />
            @if($errors->has('txtName'))<span class='help-block'>{{$errors->first('txtName', ':message')}}</span>@endif            
        </div>  
        @endif    
        <div class="form-group">
            <label>Staffs List</label>
            <select id="e2" multiple="multiple" name="staff[]" style="width: 100%;;">
                @foreach($developer as $item)
                <option value="{{$item->id}}" />{{$item->name}} - <span>{{$item->email}}</span>                                            
                @endforeach
            </select>
            @if($errors->has('staff'))<span class='help-block'>{{$errors->first('staff', ':message')}}</span>@endif            
        </div>
    </div>
</div>

<!-- Form Actions -->

<div class="form-group">
    <div class="col-md-12">
        <button type="reset" onclick="history.go(-1);" class="btn btn-sm btn-warning">
            <span class="glyphicon glyphicon-remove-circle"></span> Cancel
        </button>
        <button type="submit" class="btn btn-sm btn-success">
            <span class="glyphicon glyphicon-ok-circle"></span>
            @if (isset($staff))
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
<script src="{{url(asset('public/assets/js/select2/select2.js'))}}"></script>
<script type="text/javascript">
    $("#e2").select2({
        placeholder: "Select a Developer",
        allowClear: true
    });
</script>
@stop

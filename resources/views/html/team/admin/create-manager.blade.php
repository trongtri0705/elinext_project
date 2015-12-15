@extends('html.master')
{{-- Content --}}
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li>
        <a href="{{url('admin/team/manager')}}">{{$title}}</a>
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
        <!-- Tabs -->
<div class="col-lg-12">
    @include('html.block.message')
</div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab"></a></li>
</ul>
<!-- ./ tabs -->
@if (isset($staff))
{!! Form::model($staff, array('url' => URL::to('admin/create-manager') . '/' . $staff->id, 'method' => 'put','id'=>'fupload', 'class' => 'bf', 'files'=> true)) !!}
@else
{!! Form::open(array('url' => URL::to('admin/create-manager'), 'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
@endif
<input type="hidden" name="_token" value="{!! csrf_token()!!}" />
        <!-- Tabs Content -->
<div class="tab-content">
    <!-- General tab -->
    <div class="tab-pane active" id="tab-general">                 
        <div class="form-group">
            <label>Staffs List</label>
            <select id="e2" multiple="multiple" name="staff[]" style="width: 100%;">
                @foreach($developer as $item)
                    <option value="{{$item->id}}" />{{$item->name}} - {{$item->email}}                                            
                @endforeach
            </select>
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

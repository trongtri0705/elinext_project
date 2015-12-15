@extends('html.master')
@section('css')
<link href="{{url(asset('public/assets/css/demo.min.css'))}}" rel="stylesheet" />
@stop
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li>
        <a href="{{url('admin/review')}}">Review</a>
    </li>
    <li class="active">@if (isset($review))
        Edit
        @else
        Create
        @endif</li>
    </ul>
    @stop
    @section('content')  
    {!! Form::open(array('method' => 'post', 'class' => 'form-horizontal','id'=>'fupload', 'files'=> true)) !!}      
    <!-- Tabs Content --> 
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-xs-12">
            <div class="title">Create Review for: {{$user->name}}</div>                                
            <style type="text/css">
                .title {
                    font-size: 48px;
                    margin-bottom: 40px;
                    font-family: 'Lato';
                }
            </style>
        </div>
    </div>
    <div class="row">  
        <div class="col-lg-4 col-sm-6 col-xs-12">
            <div class="well with-header">
                <div class="header bordered-themeprimary"> Give a mark</div>
                <div class="knob-container">                        
                    <input name="point" class="knob" data-angleoffset=185 data-linecap=round data-fgcolor="#5DB2FF" value="1" data-thickness=".15">
                </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-xs-12">
            <div class="widget flat radius-bordered">
                <div class="widget-header bordered-bottom bordered-themeprimary">
                    <span class="widget-caption">Comment</span>
                    <div class="widget-buttons">
                        <a href="#" data-toggle="maximize">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <textarea name="content" id="summernote"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ./ tabs content -->


    <!-- Form Actions -->

    <div class="form-group">
        <div class="col-md-12">
            <button onclick="javascript:window.location.href='{{url('admin/staff')}}'; return false;" type="reset" class="btn btn-sm btn-warning">
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
<script src="{{url(asset('public/assets/js/editors/summernote/summernote.js'))}}"></script>
<script>
    $('#summernote').summernote({ height: 300 });
</script>
<script src="{{url(asset('public/assets/js/knob/jquery.knob.js'))}}"></script>
<script type="text/javascript">
    $(".knob").knob();
</script>
@endsection
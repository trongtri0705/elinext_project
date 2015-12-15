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
   
 </ul>
@stop
@section('content')
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-xs-12">
            <div class="title">Creater: {{$review->creater->name}}</div> 
            <div class="title">Created for: {{$review->user->name}}</div>                                
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
                <div class="header bordered-themeprimary">{{$review->user->name}}'s Mark</div>
                <div class="knob-container">
                    <input name="point" data-readonly="true" disabled class="knob" data-angleoffset=185 data-linecap=round data-fgcolor="#5DB2FF" value="{{$review->point}}" data-thickness=".15">
                </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-xs-12">
            <div class="widget flat">
                <div class="widget-header bordered-bottom bordered-platinum">
                    <span class="widget-caption">Comment</span>
                </div><!--Widget Header-->
                <div class="widget-body">
                    {!!$review->comment!!}
                </div><!--Widget Body-->
            </div><!--Widget-->
        </div>
    </div>
@stop
@section('script')
<script src="{{url(asset('public/assets/js/knob/jquery.knob.js'))}}"></script>
<script type="text/javascript">
    $(".knob").knob();
</script>
@endsection
@extends('html.master')
@section('css')
<link href="{{ url('public/assets/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
@stop
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li class="active">Profile</li>
</ul>
@stop
@section('content')
@include('html.block.message')
<div class="row">
    <div class="col-xs-12 col-md-12" style="margin-bottom:10px">
        <a href="{!! URL::to('admin/team/manager/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> Create Your Team</a>
        <a class="btn btn-sm btn-danger shiny " href="{{url('admin/team')}}">My Teams</a>               
    </div> 
    <div class="col-md-12">
        <div class="profile-container">
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">                                
                            @foreach($department as $item)
                            <li class="@if($item->id==1){{'active'}}@endif">
                                <a data-toggle="tab" href="#{{$item->id}}">
                                    {{$item->name}}
                                </a>
                            </li>                            
                            @endforeach
                        </ul>
                        <div class="tab-content tabs-flat"> 
                            @foreach($department as $dep)                                
                                <div id="{{$dep->id}}" class="tab-pane @if($dep->id==1){{' active'}}@endif">                                                                                                           
                                {!! Form::open(array('url' => URL::to('admin/staff/clear'),'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
                                    <div style="padding-bottom:10px;">
                                        <a href="{!! URL::to('admin/department/add/'.$dep->id) !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
                                        <button type="submit" class="btn btn-sm btn-darkorange">
                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                            Delete selected
                                        </button>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover" id="table{{$dep->id}}">
                                        <thead>
                                            <tr>
                                                <th style="width:31.7778px">
                                                    <div class="checker"><span class=""><input type="checkbox" class="group-checkable" data-set="#flip .checkboxes"></span></div>
                                                </th>
                                                <th></th>
                                                <th>
                                                    Name
                                                </th>                                                                       
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($dep->user as $item)
                                            @if($item->role_id<3)
                                                <tr>
                                                    <td>
                                                        <div class="checker"><span class=""><input type="checkbox" class="checkboxes" name="checkbox[]" value="{{$item->id}}"></span></div>
                                                    </td> 
                                                    <td>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:0 10px 0 0;">
                                                                        <img height="128px" src="{{asset('public/assets/images/'.getImage($item->id))}}" onerror="this.src='{!!asset("public/assets/images/default.jpg")!!}'">
                                                                    </td>
                                                                    <td>
                                                                        <table class="child-table">
                                                                            <tr><td width="100px">Email: </td><td class="themeprimary">{{$item->email}}</td></tr>               
                                                                            <tr><td>Position: </td><td class="themesecondary">{{$item->role->name}} - {{$item->level['name']}}</td></tr>               
                                                                            <tr><td>Age: </td><td>{{substr(date('Ymd')-date('Ymd', strtotime($item->birthday)), 0, -4)}}</td></tr>               
                                                                            <tr><td>Website: </td><td>@if($item->profile->website)<a target="_blank" href="{{$item->profile->website}}">{{$item->profile->website}}</a>@endif</td></tr>
                                                                            <tr><td>Status: </td><td>@if($item->active==1)<span class="label label-success graded">Active</span>@else<span class="label label-danger graded">Inactive</span>@endif</td></tr>
                                                                        </table>                                                                
                                                                    </td>
                                                                </tr>                                                         
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td style="padding-top:50px;" class="themeprimary">
                                                        {!!$item->name!!}
                                                    </td>                            
                                                    <td style="padding-top:50px;">                            
                                                        <a href="{!!URL('admin/staff/'.$item['id'].'/edit')!!}" class="btn btn-primary btn-xs update"><i class="fa fa-edit"></i> Edit</a>                                                        
                                                        <a href="{!!URL('admin/department/'.$item['id'].'/delmember')!!}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
                                                        @if(!(($item->review->first()['reviewer_id']==Auth::user()->id) && date('m',strtotime($item->review->last()['created_at']))==date("m")))
                                                        <a href="{!!URL('admin/review/create/'.$item['id'])!!}" class="btn btn-azure graded btn-xs update"><i class="fa fa-play"></i> Make Review</a>
                                                        @else
                                                        <a href="{!!URL('admin/review/'.$item['id'])!!}" class="btn btn-default graded btn-xs update"><i class="fa fa-eye"></i>Review</a>
                                                        @endif
                                                    </td>
                                                </tr> 
                                            @endif                                            
                                        @endforeach 
                                        </tbody>
                                    </table>  
                                </form>                                 
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
@section('script')
@foreach($department as $dep)
<script type="text/javascript">    
    var oTable = $("#table{{$dep->id}}").dataTable({
            "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
             "aLengthMenu": [
                    [5, 15, 25, -1],
                    [5, 15, 25, "All"]
                    ],
                    "iDisplayLength": 5,
            "oTableTools": {
                "aButtons": [
                {
                    'sExtends': 'xls', 
                    "mColumns": [0,1],
                    "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
                }, 
                {
                    'sExtends': 'pdf', 
                    "mColumns": [0,1],
                    "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
                }, 
                {
                    'sExtends': 'print',
                    "bShowAll": false, 
                    "mColumns": [0,1],
                    "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
                }
                ],
            "sSwfPath": "{{url('public/assets/swf/copy_csv_xls_pdf.swf')}}"
                
            },
            "language": {
                "search": "",
                "sLengthMenu": "_MENU_",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumns": [ 
            { "bSortable": false },   
            { "bSortable": false },       
            null,
            { "bSortable": false },        
            ],
            "aaSorting": []
        });
        jQuery("#table{{$dep->id}} .group-checkable").change(function () {
            var set = $("#table{{$dep->id}} .checkboxes");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });

        });
        jQuery('#table{{$dep->id}} tbody tr .checkboxes').change(function () {
            $(this).parents('tr').toggleClass("active");
        });
</script>
@endforeach
@endsection
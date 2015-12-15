@extends('html.master')
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li class="active">My Teams</li>
</ul>
@stop
@section('content')
<div class="row">           
        <div class="col-xs-12 col-md-12">       
            @include('html.block.message')  
        </div>
    </div>
<div class="row">
    <div class="col-xs-12 col-md-12" style="padding-bottom:10px;">        
        @if(Auth::user()->role_id==3)
            <a href="{!! URL::to('admin/team/manager/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
        @else
            <a href="{!! URL::to('admin/team/leader/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
        @endif
    </div>                    
    <div class="col-xs-12 col-md-12">
        @include('html.block.message')
    </div>    
    {!! Form::open(array('url' => URL::to('admin/team/clear'),'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
    @foreach($list as $detail)    
    <div class="col-xs-12 col-md-12">    	
        <div class="widget">
            <div class="widget-header ">
              <span class="widget-caption">{{$detail->name}}</span>
              @if(Auth::user()->role_id==3)
              <a href="{!! URL::to('admin/team/manager/add/'.$detail->id) !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
              @else
              <a href="{!! URL::to('admin/team/leader/add/'.$detail->id) !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
              @endif
              <a href="{!! URL::to('admin/team/delete/'.$detail->id) !!}" class="btn btn-sm  delete btn-danger iframe cboxElement"><span class="glyphicon glyphicon-remove-sign"></span> Delete Team</a>
              <div class="widget-buttons">
                <a href="#" data-toggle="maximize">
                    <i class="fa fa-expand"></i>
                </a>
                <a href="#" data-toggle="collapse">
                    <i class="fa fa-minus"></i>
                </a>
                <a href="#" data-toggle="dispose">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="widget-body">
            <table class="table table-striped table-bordered table-hover" id="{{$detail->id}}">
                <thead>
                    <tr>
                        <th style="width:31.7778px">
                            <div class="checker"><span class=""><input type="checkbox" class="group-checkable" data-set="#flip .checkboxes"></span></div>
                        </th>
                        <th>
                            
                        </th>                            
                        <th>
                            Name
                        </th>                                                     
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($detail->detail as $item)
                    <tr>
                        <td>
                            <div class="checker"><span class=""><input type="checkbox" class="checkboxes" name="checkbox[]" value="{{$item->id}}"></span></div>
                        </td>   
                        <td>                        
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="padding:0 10px 0 0;">
                                            <img height="128px;" src="{{asset('public/assets/images/'.getImage($item->account['id']))}}" onerror="this.src='{!!asset("public/assets/images/default.jpg")!!}'">
                                        </td>
                                        <td >
                                            <table class="child-table">
                                                <tr><td width="100px">Name: </td><td>{!!$item->account['name'] !!}</td></tr>
                                                <tr><td>Position: </td><td>{{$item->account['role']->name}}</td></tr>               
                                                <tr><td>Age: </td><td>{{substr(date('Ymd')-date('Ymd', strtotime($item->account['birthday'])), 0, -4)}}</td></tr>               
                                                <tr><td>Website: </td><td><a target="_blank" href="'.{{$item->account['profile']['website']}}.'">{{$item->account['profile']['website']}}</a></td></tr>
                                                <tr><td>Status: </td><td>@if($item->account['active']==1)<span class="label label-success graded">Active</span>@else<span class="label label-danger graded">Inactive</span>@endif</td></tr>
                                            </table>                                                                                                       
                                        </td>
                                    </tr>                                                         
                                </tbody>
                            </table>
                        </td>
                        <td style="padding-top:50px;">
                            <a href="{{url('admin/staff/'.$item->account['id'].'/edit')}}">{!!$item->account['name']!!}</a>
                        </td>                            
                        <td style="padding-top:50px;">                                                        
                            <a href="{!!URL('admin/team/manager/'.$detail->id.'/'.$item->account['id'].'/delete')!!}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
                <tfoot>
                        <tr>
                            <td colspan="4">
                                <button type="submit" class="btn btn-sm btn-darkorange">
                                    <span class="glyphicon glyphicon-ok-circle"></span>
                                    Delete selected
                                </button>
                            </td>
                                   
                        </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </div>
    @endforeach
    </form>   
</div>
@endsection
@section('script')
@foreach($list as $detail)
<script>
    var oTable = $("#{{$detail->id}}").dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 10,
        "oTableTools": {
            "aButtons": [
            {
                'sExtends': 'xls', 
                "mColumns": [1],
                "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
            }, 
            {
                'sExtends': 'pdf', 
                "mColumns": [1],
                "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
            }, 
            {
                'sExtends': 'print',
                "bShowAll": false, 
                "mColumns": [1],
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

            //Check All Functionality
    jQuery("#{{$detail->id}} .group-checkable").change(function () {
        var set = $("#{{$detail->id}} .checkboxes");
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
    jQuery('#{{$detail->id}} tbody tr .checkboxes').change(function () {
        $(this).parents('tr').toggleClass("active");
    });
</script>
@endforeach
@endsection

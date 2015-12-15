@extends('html.master')
@section('controller',$title)
@section('action','List')
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li class="active">Level</li>
</ul>
@stop
@section('content')
<!-- Page Content -->
<div class="row">    
    <div class="col-xs-12 col-md-12">
        <a href="{!! URL::to('admin/level/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
    </div>                    
    <div class="col-xs-12 col-md-12">
        @include('html.block.message')        
    </div>    
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">                
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
                {!! Form::open(array('url' => URL::to('admin/level/clear'),'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
                <table class="table table-striped table-bordered table-hover" id="simpledatatable">
                    <thead>
                        <tr role="row">                            
                            <th style="width:31.7778px">
                                <div class="checker"><span class=""><input type="checkbox" class="group-checkable" data-set="#flip .checkboxes"></span></div>
                            </th>
                            <th>
                                Name
                            </th> 
                            <th> 
                                Role                               
                            </th>                                                     
                            <th>                                
                            </th>                                                        
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($data as $item)
                       <tr> 
                           <td>
                            <div class="checker"><span class=""><input type="checkbox" class="checkboxes" name="checkbox[]" value="{{$item->id}}"></span></div>
                        </td>                            
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->role['name']}}
                        </td>
                        <td>
                            <a href="{!!URL('admin/level/'.$item['id'].'/edit')!!}" class="btn btn-primary btn-xs update"><i class="fa fa-edit"></i> Edit</a>
                            <a href="{!!URL('admin/level/'.$item['id'].'/delete')!!}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
                        </td> 
                    </tr> 
                    @endforeach 
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <button type="submit" class="btn btn-sm btn-darkorange">
                                    <span class="glyphicon glyphicon-ok-circle"></span>
                                    Delete selected
                                </button>
                            </td>                            
                        </tr>
                    </tfoot>                       
                </tbody>
            </table>
        </form>
        <div class="dd shadowed">
            <ol class="dd-list">
                @foreach($list as $item)                               
                    <li class="dd-item" data-id="3">
                        <div class="dd-handle">
                            {{$item->name}}
                        </div>
                        <ol class="dd-list">
                            @if($item->level)
                                @foreach($item->level as $key => $level)
                                @if($key%3==0)
                                <li class="dd-item bordered-blue" data-id="6">
                                    <div class="dd-handle"> {{$level->name}} </div>
                                </li>
                                @elseif($key%3==1)
                                <li class="dd-item bordered-palegreen" data-id="7">
                                    <div class="dd-handle"> {{$level->name}}</div>
                                </li>
                                @else
                                <li class="dd-item bordered-danger" data-id="8">
                                    <div class="dd-handle"> {{$level->name}}</div>
                                </li>
                                @endif
                                @endforeach
                            @endif
                        </ol>
                    </li>
                   
                @endforeach
            </ol>
        </div>
    </div>
</div>
</div>
</div>
<!-- /#page-wrapper -->
@endsection()
@section('script')   
<script src="{{url('public/assets/js/nestable/jquery.nestable.min.js')}}"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $('.dd').nestable({
            protectRoot:true,
        });
        $('.dd-handle a').on('mousedown', function (e) {
            e.stopPropagation();
        });
    });
</script> 
<script>
    var oTable = $('#simpledatatable').dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 10,
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
                "mColumns": [0,1],
                "bShowAll": false, 
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
        null,null,
        { "bSortable": false },        
        ],
        "aaSorting": []
    });
            //Check All Functionality
            jQuery('#simpledatatable .group-checkable').change(function () {
                var set = $(".checkboxes");
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
            jQuery('#simpledatatable tbody tr .checkboxes').change(function () {
                $(this).parents('tr').toggleClass("active");
            });
        </script>
        @endsection
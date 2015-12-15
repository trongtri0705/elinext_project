@extends('html.master')
@section('controller',$title)
@section('action','List')
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li class="active">Department</li>
</ul>
@stop
@section('content')

<!-- Page Content -->
<div class="row">
    <div class="col-xs-12 col-md-12">
        <a href="{!! URL::to('admin/department/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
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
                {!! Form::open(array('url' => URL::to('admin/department/clear'),'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
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
                            </th>                                                        
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($data as $item)
                       <tr> 
                           <td>
                            <div class="checker"><span class=""><input @if($item->id<7){{"disabled"}}@endif type="checkbox" class="checkboxes" name="checkbox[]" value="{{$item->id}}"></span></div>
                            </td>                           
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                            @if($item->id>6)
                                <a href="{!!URL('admin/department/'.$item['id'].'/edit')!!}" class="btn btn-primary btn-xs update"><i class="fa fa-edit"></i> Edit</a>
                                <a href="{!!URL('admin/department/'.$item['id'].'/delete')!!}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
                            @endif
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
    </div>
</div>
</div>
</div>

<!-- /#page-wrapper -->
@endsection()
@section('script')    
<script>
    var oTable = $('#simpledatatable').dataTable({
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
        null,
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
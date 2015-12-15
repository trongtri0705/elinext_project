@extends('html.master')
@section('controller',$title)
@section('action','List')
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li class="active">Staff</li>
</ul>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12 col-md-12">
        <a href="{!! URL::to('admin/staff/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
    </div>                    
    <div class="col-xs-12">
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
                <table class="table table-striped table-bordered table-hover" id="expandabledatatable">
                    <thead>
                        <tr>
                            <th>
                                Name
                            </th>                            
                            <th>
                                Age
                            </th>                                                     
                            <th>Picture</th>
                            <th>Position</th>
                            <th></th>
                            <th>Status</th>
                            <th></th>
                            <th>Point</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $item)
                            @if(Auth::user()->role_id==4)                        
                            <tr>
                                <td>
                                    <a href="{{url('admin/staff/'.$item->id.'/edit')}}">{!!$item->name!!}</a>
                                </td>
                                <td>
                                    {{substr(date('Ymd')-date('Ymd', strtotime($item->birthday)), 0, -4)}}
                                </td>                            
                                <td>
                                    {{getImage($item->id)}}
                                </td>
                                <td>
                                    {{$item->role->name}} - {{$item->level['name']}}
                                </td>
                                <td>
                                    {{$item->profile->website}}
                                </td>
                                <td>
                                    @if($item->active==1)
                                    <span class="label label-success graded">
                                        Active
                                    </span>
                                    @else
                                    <span class="label label-danger graded">
                                    Inactive
                                    </span>
                                    @endif
                                </td>
                                <td>                            
                                    <a href="{!!URL('admin/staff/'.$item['id'].'/edit')!!}" class="btn btn-primary btn-xs update"><i class="fa fa-edit"></i> Edit</a>                                    
                                    <a href="{!!URL('admin/staff/'.$item['id'].'/delete')!!}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
                                    @if((($item->review->first()) && date('m',strtotime($item->review->first()['created_at']))==date("m")))
                                        <a href="{!!URL('admin/review/'.$item['id'])!!}" class="btn btn-default graded btn-xs update"><i class="fa fa-eye"></i>Review</a>
                                    @endif
                                </td>
                                <td>
                                    {{getAvgLast($item)}} - {{getAvgNow($item)}}
                                    <span>                                        
                                        @if(getAvgNow($item) > getAvgLast($item))                                        
                                            <i class="fa fa-arrow-up green"></i>
                                        @elseif(getAvgNow($item) < getAvgLast($item))
                                            <i class="fa fa-arrow-down red"></i>
                                        @else
                                            <i class="fa fa-arrows-h"></i>                                    
                                        @endif
                                    </span>                                    
                                </td>
                            </tr>
                            @elseif(Auth::user()->role_id==2)
                                @if($item->role_id<=2)
                                <tr>
                                    <td>
                                        <a href="{{url('admin/staff/'.$item->id.'/edit')}}">{!!$item->name!!}</a>
                                    </td>
                                    <td>
                                        {{substr(date('Ymd')-date('Ymd', strtotime($item->birthday)), 0, -4)}}
                                    </td>                            
                                    <td>
                                        {{getImage($item->id)}}
                                    </td>
                                    <td>
                                        {{$item->role->name}}
                                    </td>
                                    <td>
                                        {{$item->profile->website}}
                                    </td>
                                    <td>
                                        @if($item->active==1)
                                        <span class="label label-success graded">
                                            Active
                                        </span>
                                        @else
                                        <span class="label label-danger graded">
                                        Inactive
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Auth::user()->id==$item->id)                                         
                                            <a class="themeprimary">You're here</a>
                                        @elseif(!(($item->review->first()) && date('m',strtotime($item->review->first()['created_at']))==date("m")))
                                            <a href="{!!URL('admin/review/create/'.$item['id'])!!}" class="btn btn-azure graded btn-xs update"><i class="fa fa-play"></i> Make Review</a>
                                        @endif                                        
                                    </td>
                                    <td>
                                         {{getAvgLast($item)}} - {{getAvgNow($item)}}
                                        <span>                                        
                                            @if(getAvgNow($item) > getAvgLast($item))                                        
                                                <i class="fa fa-arrow-up green"></i>
                                            @elseif(getAvgNow($item) < getAvgLast($item))
                                                <i class="fa fa-arrow-down red"></i>
                                            @else
                                                <i class="fa fa-arrows-h"></i>                                    
                                            @endif
                                        </span>                                      
                                    </td>
                                </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection()
@section('script')
<script type="text/javascript">
    function fnFormatDetails(oTable, nTr) {
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table>';
        sOut += '<tr><td rowspan="5" style="padding:0 10px 0 0;"><img height="128px" src="{{asset("public/assets/images")}}' +'/'+ aData[3] + '" onerror=\'this.src="'+"{!!asset('public/assets/images/default.jpg')!!}"+'"\'></td><td>Name:</td><td>' + aData[1] + '</td></tr>';                
        sOut += '<tr><td>Age:</td><td>' + aData[2] + '</td></tr>';                
        sOut += '<tr><td>Website:</td><td><a target="_blank" href="'+aData[5]+'">'+aData[5]+'</a></td></tr>';
        sOut += '</table>';
        return sOut;
    }

    /*
     * Insert a 'details' column to the table
     */
     var nCloneTh = document.createElement('th');
     var nCloneTd = document.createElement('td');
     nCloneTd.innerHTML = '<i class="fa fa-plus-square-o row-details"></i>';

     $('#expandabledatatable thead tr').each(function () {
        this.insertBefore(nCloneTh, this.childNodes[0]);
    });

     $('#expandabledatatable tbody tr').each(function () {
        this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
    });

    /*
     * Initialize DataTables, with no sorting on the 'details' column
     */
     var oTable = $('#expandabledatatable').dataTable({
        "sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",                
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [0,6,7] },
        { "bVisible": false, "aTargets": [3,5] }
        ],
        "aLengthMenu": [
        [5, 15, 25, -1],
        [5, 15, 25, "All"]
        ],
        "iDisplayLength": 5,
        "oTableTools": {
            "aButtons": [                        
            {
                'sExtends': 'print',
                "bShowAll": false,
                "mColumns": [1,2],                             
                "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
            },
            {
                'sExtends': 'xls', 
                "mColumns": [1,2],                                    
                "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
            }, 
            {
                'sExtends': 'pdf', 
                "mColumns": [1,2],
                "oSelectorOpts": { filter: 'applied', order: 'current',page: 'current', }
            } ],
            "sSwfPath": "{{url('public/assets/swf/copy_csv_xls_pdf.swf')}}"
        },
        "language": {
            "search": "",
            "sLengthMenu": "_MENU_",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        }
    });


$('#expandabledatatable').on('click', ' tbody td .row-details', function () {
    var nTr = $(this).parents('tr')[0];
    if (oTable.fnIsOpen(nTr)) {
        /* This row is already open - close it */
        $(this).addClass("fa-plus-square-o").removeClass("fa-minus-square-o");
        oTable.fnClose(nTr);
    }
    else {
        /* Open this row */
        $(this).addClass("fa-minus-square-o").removeClass("fa-plus-square-o");;
        oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
    }
});

$('#expandabledatatable_column_toggler input[type="checkbox"]').change(function () {
    var iCol = parseInt($(this).attr("data-column"));
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    oTable.fnSetColumnVis(iCol, (bVis ? false : true));
});

$('body').on('click', '.dropdown-menu.hold-on-click', function (e) {
    e.stopPropagation();
})
</script>
@endsection

@extends('html.master')
@section('crumb')
<ul class="breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{url()}}">Home</a>
    </li>
    <li class="active">Review List In This Month</li>
</ul>
@stop
@section('content')
<div class="row">   
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
                                Reviewer
                            </th>                            
                            <th>
                                Point
                            </th>                                                     
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $item) 
                            @if(date('m',strtotime($item->created_at))==date("m"))                                                                                                                                                                      
                                <tr>
                                    <td>
                                        {!!$item->creater->name!!} - {!!$item->creater->email!!}
                                    </td>
                                    <td>
                                        {{$item->point}}
                                    </td>                                                            
                                    <td>
                                        {!!$item->comment!!}
                                    </td>                                
                                </tr>  
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
        sOut += '<tr><td>Comment:</td><td><a target="_blank">'+aData[3]+'</a></td></tr>';
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
        { "bSortable": false, "aTargets": [0,1,2] },
        { "bVisible": false, "aTargets": [3] }
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

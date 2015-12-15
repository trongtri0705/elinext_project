@extends('html.master')
@section('css')

@stop
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
		<a href="{!! URL::to('admin/team/leader/create') !!}" class="btn btn-sm  btn-primary iframe cboxElement"><span class="glyphicon glyphicon-plus-sign"></span> Create New Team</a>		
		<a class="btn btn-sm btn-danger shiny " href="{{url('admin/leader/addmember')}}"><span class="glyphicon glyphicon glyphicon-ok-sign"></span> Create New Developer</a>               
		<a class="btn btn-sm btn-success shiny " href="{{url('admin/team')}}">My Teams</a>               
	</div>                    
	<div class="col-xs-12 col-md-12">
		@include('html.block.message')
	</div> 		
	
	<div class="col-xs-12 col-md-12">    	
		<div class="widget">
			{!! Form::open(array('url' => URL::to('admin/staff/clear'),'method' => 'post', 'class' => 'bf','id'=>'fupload', 'files'=> true)) !!}
				<div class="widget-header ">
					<span class="widget-caption">{{$list->name}}</span>					
					<button type="submit" class="btn btn-sm btn-darkorange">
		                <span class="glyphicon glyphicon-ok-circle"></span>
		                Delete selected
		            </button>
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
							@foreach($list->user as $item)                           
	                            <tr>
	                                <td>
	                                    @if($item->role_id==1)<div class="checker"><span class=""><input type="checkbox" class="checkboxes" name="checkbox[]" value="{{$item->id}}"></span></div>@endif
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
	                                                        <tr><td width="100px">Position: </td><td class="themesecondary">{{$item->role->name}}</td></tr>               
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
	                                	@if($item->role_id==1)                          
		                                    <a href="{!!URL('admin/staff/'.$item['id'].'/edit')!!}" class="btn btn-primary btn-xs update"><i class="fa fa-edit"></i> Edit</a>		                                    
		                                    <a href="{!!URL('admin/department/'.$item['id'].'/delmember')!!}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
		                                @endif
		                                @if(Auth::user()->id==$item->id)                                         
                                            <a class="themesecondary">You're here</a>
                                        @else
                                        	@if(!(($item->review->last()) && date('m',strtotime($item->review->last()['created_at']))==date("m")))
	                                    	<a href="{!!URL('admin/review/create/'.$item['id'])!!}" class="btn btn-azure graded btn-xs update"><i class="fa fa-play"></i> Make Review</a>
		                                    @else
		                                    	<a href="{!!URL('admin/review/'.$item['id'])!!}" class="btn btn-default graded btn-xs update"><i class="fa fa-eye"></i>Review</a>
		                                    @endif
                                        @endif
		                                
	                                </td>
	                            </tr>                                                                      
	                        @endforeach 
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>	
</div>
@endsection()
@section('script')
<script type="text/javascript">    
    var oTable = $("#expandabledatatable").dataTable({
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
        jQuery("#expandabledatatable .group-checkable").change(function () {
            var set = $("#expandabledatatable .checkboxes");
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
        jQuery('#expandabledatatable tbody tr .checkboxes').change(function () {
            $(this).parents('tr').toggleClass("active");
        });
</script>
@endsection
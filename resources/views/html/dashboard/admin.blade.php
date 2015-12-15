@extends('html.master')
@section('content')
@include('html.block.message')
<div class="col-xs-12 col-sm-12 col-xs-12">
	<div class="well with-footer">
		<div class="header bordered-blue">
			<div class="btn-group">
				<a class="btn btn-primary " href="javascript:void(0);">Create Manager</a>
				<a class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
				<ul class="dropdown-menu dropdown-primary">
					<li>
						<a href="{{url('admin/create-new-manager')}}">New</a>						
					</li>
					<li>
						<a href="{{url('admin/create-manager')}}">From Current Staffs</a>
					</li>
				</ul>				
			</div>
			<div class="btn-group">
				<a class="btn btn-primary " href="javascript:void(0);">Create Leader</a>
				<a class="btn btn-primary  dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
				<ul class="dropdown-menu dropdown-primary">
					<li>
						<a href="{{url('admin/create-new-leader')}}">New</a>						
					</li>
					<li>
						<a href="{{url('admin/create-leader')}}">From Current Staffs</a>
					</li>
				</ul>				
			</div>
		</div>
	</div>	
</div>
@foreach($model as $item)
<div class="col-xs-12 col-md-6 col-lg-6">
	<div class="widget">
		<div class="widget-header ">
			<span class="widget-caption">{{$item->name}}</span>
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
			<div id="{{$item->name}}" class="chart donut-chart chart-lg"></div>
		</div>
	</div>
</div>
@endforeach
@stop

@section('script')
<script src="{{url(asset('public/assets/js/charts/morris/raphael-2.0.2.min.js'))}}"></script>
<script src="{{url(asset('public/assets/js/charts/morris/morris.js'))}}"></script>
<script src="{{url(asset('public/assets/js/charts/morris/morris-init.js'))}}"></script>
@foreach($model as $item)
<script type="text/javascript">	
	Morris.Donut({
		element: "{{$item->name}}",
		data: [ 
		{ label: 'Developer', value: @if(@count($item->user)>0) {{ @round(@count($item->developer)*100/count($item->user), 2)}}@else {{0}} @endif, },       
		{ label: 'Leader', value: @if(@count($item->user)>0) {{@round(@count($item->leader)*100/count($item->user), 2)}}@else {{0}} @endif },
		{ label: 'Manager', value: @if(@count($item->user)>0) {{@round(@count($item->manager)*100/count($item->user), 2)}}@else {{0}} @endif }     
		],
		colors: [themeprimary, themesecondary, themethirdcolor, themefourthcolor],
		formatter: function (y) { return y + "%" }
	});
</script>
@endforeach
@stop
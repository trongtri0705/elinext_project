@extends('html.master')
@section('content')
<div class="row">
	<div class="col-xs-12 col-md-12">
		<img src="{{url('public/help/manager1.png')}}">
	</div>	
</div>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<img src="{{url('public/help/manager2.png')}}">
	</div>	
</div>

<style type="text/css">
	.col-md-12 img
	{
		width: 90%;
	}
	.col-md-12
	{
		margin-bottom: 30px;
	}
</style>
@stop

@extends('html.master')
@section('content')
	<div class="row">			
		<div class="col-xs-12 col-md-12">    	
			@include('html.block.message')	
		</div>
	</div>
	@if(Auth::user()->teamdetail)
		@foreach (Auth::user()->teamdetail as $key => $value) 				
			<div class="row">			
				<div class="col-xs-12 col-md-12">    	
					<div class="widget">
						<div class="widget-header ">
							<span class="widget-caption">Team's Name: <a class="themeprimary">{{$value->team->name}}</a>   -   Average score: 
							<?php $sum=0;?>
							@foreach ($value->team->detail as $key => $item)
								<?php $temp = 0; $count = 0; ?>			
								@foreach ($item->account->score as $key => $review) 
									@if(date('m',strtotime($review->created_at))==date("m"))								
										<?php 
											$count++;
											$temp+=($review->point);
										?>										
									@endif
								@endforeach
								@if($count>0)																	
									<?php $sum+=($temp/$count)?>									
								@endif
							@endforeach
							<a class="themesecondary">{{($sum+$value->team->creater->review->first()['point'])/(count($value->team->detail)+1)}}</a>
							</span>
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
							<table class="table table-striped table-bordered table-hover" id="{{$value->id}}">
								<thead>
									<tr>
										<th>
											Name
										</th>                            
										<th>
											Age
										</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>
											<a class="themesecondary">Creater:{!!$value->team->creater->name!!}</a>
										</td>
										<td>
											{{substr(date('Ymd')-date('Ymd', strtotime($value->team->creater['account']['birthday'])), 0, -4)}}

										</td>                            										
										<td>
											{{$value->team->creater->account['email']}}
										</td>
										<td>
											@if(!(($value->team->creater->review->first()['reviewer_id']==Auth::user()->id) && date('m',strtotime($value->team->creater->review->first()['created_at']))==date("m")))
                                                <a href="{!!URL('admin/review/create/'.$value->team->creater->id)!!}" class="btn btn-azure graded btn-xs update"><i class="fa fa-play"></i> Make Review</a>
                                            @else
                                            	<a class="themesecondary">Viewed</a>	
                                            @endif                                                                                       
										</td>
									</tr>
									@foreach ($value->team->detail as $key => $item)
									<tr>
										<td>
											{!!$item->account->name!!}
										</td>
										<td>
											{{substr(date('Ymd')-date('Ymd', strtotime($item->account->birthday)), 0, -4)}}

										</td> 
										<td>
											{{$item->account->email}}
										</td>
										<td>
										@if($item->account->id!=Auth::user()->id)
											@if(!(($item->account->review->first()['reviewer_id']==Auth::user()->id) && date('m',strtotime($item->account->review->first()['created_at']))==date("m")))
                                                <a href="{!!URL('admin/review/create/'.$item->account->id)!!}" class="btn btn-azure graded btn-xs update"><i class="fa fa-play"></i> Make Review</a>
                                            @else
                                            	<a class="themesecondary">Viewed</a>	
                                            @endif
                                        @else
                                        	<a class="themeprimary">You're here</a>                                            
                                        @endif                                       
										</td>

									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>			
		@endforeach
	@else
	<div class="title">You're free now, wait for someone adding you on.</div>                                
    <style type="text/css">
        .title {
            font-size: 48px;
            margin-bottom: 40px;
            font-family: 'Lato';
        }
    </style>
	@endif
@stop
@section('script')
@if(Auth::user()->teamdetail)
	@foreach (Auth::user()->teamdetail as $key => $value) 
		<script type="text/javascript">    
		    var oTable = $("#{{$value->id}}").dataTable({
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
		            null,
		            null, 
		            { "bSortable": false },   		           
		            { "bSortable": false }, 
		            ],
		            "aaSorting": []
		        });		        
		</script>	
	@endforeach
@endif
@endsection
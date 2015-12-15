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
    <div class="col-md-12">
        <div class="profile-container">
            <div class="profile-header row">
                <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                    <img src="{{asset('public/assets/images/'.getImage(Auth::user()->id))}}" onerror="this.src = '{!!asset("public/assets/images/default.jpg")!!}'" alt="" class="header-avatar" />                       
                    
                </div>

                <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
                    <div class="header-fullname">{{Auth::user()->name}}</div>                        
                    <div class="header-information">
                        {{explode(' ',Auth::user()->name)[0]}} is a {{(Auth::user()->role->name)}} in Elisoft.
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats">                        
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 inlinestats-col">
                            <i class="glyphicon glyphicon-map-marker"></i> {{Auth::user()->profile->address}}
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 inlinestats-col">
                            Rate: <strong>???</strong>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 inlinestats-col">
                            Age: <strong>{{substr(date('Ymd')-date('Ymd', strtotime(Auth::user()->birthday)), 0, -4)}}</strong>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">                                
                            <li class="tab-blue active">
                                <a data-toggle="tab" href="#timeline">
                                    Timelines
                                </a>
                            </li>
                            <li class="tab-red">
                                <a data-toggle="tab" id="contacttab" href="#contacts">
                                    Contacts
                                </a>
                            </li>
                            <li class="tab-palegreen">
                                <a data-toggle="tab" href="#settings">
                                    Settings
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabs-flat"> 
                            <div id="timeline" class="tab-pane active">
                                @if(Auth::user()->role_id!=4)
                                <div class="row" style="display: block;font-size: 18px;font-family: 'Roboto','Lucida Sans','trebuchet MS',Arial,Helvetica;font-weight: 400;margin: 8px 5px;position: relative;">
                                    Your score on  <span style="color:red">{{date("F Y",strtotime("-1 month"))}}</span>: <span class="stats-value primary" style="font-size:20pt;display:inline">
                                    @if(Auth::user()->has('score'))
                                        <?php $temp = 0; ?>         
                                        @foreach (Auth::user()->score as $key => $review) 
                                            @if(date('m',strtotime($review->created_at))==date("m"))                                
                                                <?php $temp+=($review->point);?>                                        
                                            @endif
                                        @endforeach
                                        @if(count(Auth::user()->score)>0)
                                            {{$temp/count(Auth::user()->score)}}
                                        @else
                                            0
                                        @endif
                                    @endif</span>
                                </div>                               
                                @else                                
                                <div class="title">Nothings!!!</div>                                
                                <style type="text/css">
                                    .title {
                                        font-size: 48px;
                                        margin-bottom: 40px;
                                        font-family: 'Lato';
                                    }
                                </style>
                                @endif
                                
                            </div>                               
                            <div id="contacts" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-contacts">

                                            <div class="profile-badge orange"><i class="fa fa-phone orange"></i><span>Contacts</span></div>
                                            <div class="contact-info">
                                                <p>
                                                    Phone   : {{Auth::user()->phone}} <br>                                                        
                                                </p>
                                                <p>
                                                    Email       : {{Auth::user()->email}}
                                                    <br>                                                        
                                                </p>                                                
                                            </div>
                                            <div class="profile-badge azure">
                                                <i class="fa fa-map-marker azure"></i><span>Location</span>
                                            </div>
                                            <div class="contact-info">
                                                <p>
                                                    Address<br>
                                                    {{Auth::user()->profile->address}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="contact-map" class="animated flipInY"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="settings" class="tab-pane">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{!! csrf_token()!!}" />
                                    <div class="form-title">
                                        Personal Information
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <label>Change Avatar</label>
                                                    <input id="input-22" name="input22" type="file" class="file-loading" accept=".jpg, .png, .jpeg">                                                    
                                                </span>                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" class="form-control" placeholder="Name" name="txtName" value="{!! old('txtName',Auth::user()->name)!!}">
                                                    <i class="fa fa-user info"></i>
                                                </span>
                                                @if($errors->has('txtName'))<span class='help-block'>{{$errors->first('txtName', ':message')}}</span>@endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" class="form-control" name="txtAddr" placeholder="Address" value="{!! old('txtAddr',Auth::user()->profile->address)!!}">
                                                    <i class="fa fa-globe success"></i>
                                                </span>
                                                @if($errors->has('txtAddr'))<span class='help-block'>{{$errors->first('txtAddr', ':message')}}</span>@endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input class="form-control" name="txtPhone" placeholder="Phone" type='tel' pattern='\d{10,11}' value="{!! old('txtPhone',Auth::user()->phone)!!}" />
                                                    <span>format: 0123456789(0)</span>
                                                    <i class="glyphicon glyphicon-earphone yellow"></i>
                                                </span>
                                                @if($errors->has('txtPhone'))<span class='help-block'>{{$errors->first('txtPhone', ':message')}}</span>@endif
                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input class="form-control" type="text" id="datepicker" name="txtBirth" size="20" value="{!! old('txtBirth',Auth::user()->birthday)!!}" placeholder="Birthday "/>            
                                                    <i class="fa fa-calendar red"></i>
                                                </span>
                                                @if($errors->has('txtBirth'))<span class='help-block'>{{$errors->first('txtBirth', ':message')}}</span>@endif
                                            </div>
                                        </div>                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input class="form-control" name="txtWebsite" placeholder="Web Site" type='url' value="{!! old('txtWebsite',Auth::user()->profile->website)!!}" />
                                                    <span>format: http://www.abc.zyz</span>
                                                    <i class="fa fa-chrome purple"></i>
                                                </span>
                                                @if($errors->has('txtPhone'))<span class='help-block'>{{$errors->first('txtPhone', ':message')}}</span>@endif
                                            </div>
                                        </div>                                     
                                    </div>
                                    <hr class="wide">
                                    <button type="submit" class="btn btn-primary">Save Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ url('public/assets/js/fileinput.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
        $("#input-22").fileinput({
            showCaption: false,
            allowedFileExtensions: ["png", "jpg","jpeg"], 
            showUpload: false          
        });
    });     
</script>
<script type="text/javascript">

</script>
<script>
        //Google Map
        $('#contacttab').click(function () {

            function initialize() {                
                var x,y;
                var address = "{{Auth::user()->profile->address}}";
                $.ajax({
                  url: "http://maps.googleapis.com/maps/api/geocode/json?address="+address+"&sensor=false",
                  type: "POST",
                  success: function(res){
                   x=(res.results[0].geometry.location.lat);
                   y=(res.results[0].geometry.location.lng);
                   var myLatlng = new google.maps.LatLng(x, y);
                   var mapOptions = {
                    zoom: 20,
                    scrollwheel: false,
                    center: myLatlng,
                    scaleControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP 
                }
                var map = new google.maps.Map(document.getElementById('contact-map'), mapOptions);
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: 'Map'
                });
            }
        });

            }
            google.maps.event.addDomListener(window, 'click', initialize);
        });        
</script>
@stop

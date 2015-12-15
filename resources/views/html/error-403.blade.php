@extends('html.morepage.layout')
@section('content')
<body class="body-500">
    <div class="error-header"> </div>
    <div class="container ">
        <section class="error-container text-center">
            <h1>403</h1>
            <div class="error-divider">
                <h2>Whoops!!!</h2>
                <p class="description">You do not have permission to access.</p>
            </div>
            <a onclick="history.go(-1); return false;" style="cursor:pointer" class="return-btn"><i class="fa  fa-step-backward"></i>Back</a>
            <a href="{{url()}}" style="cursor:pointer" class="return-btn"><i class="fa fa-home"></i>Home</a>
        </section>
    </div>
    <!--Basic Scripts-->
@stop
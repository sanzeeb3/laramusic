<!DOCTYPE html>
<html lang="en">
<head>
<title>Fresh Laravel</title>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('jquery.validate.min.js')}}"></script>
<link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet">
<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
<link href="{{asset('sweetalert.css')}}" rel="stylesheet">
<script src="{{asset('sweetalert.js')}}"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> -->
</head>
<style>
#question
{
	color:red;
}
</style>
<body>
<div class="container-fluid" style="background-color:#F44336;color:#fff;height:120px;">
  <h1>Khelbazar.com</h1>
  <h3>Bet the matches, win the price, live EPL</h3> 
</div>

<nav class="navbar navbar-inverse">
      <ul class="nav navbar-nav">
      
        <li class=""><a href="" class="glyphicon glyphicon-triangle-left" onclick="history.go(-1);">Back</button></a></li>
        <li class="active"><a href="{{url('/bet')}}"><span class="glyphicon glyphicon-home home"></span> Home</a></li>
           
            <?php if(Auth::check()) 
            {
                ?><li class="active"><a href="{{url('/auth/logout')}}"><span class="glyphicon glyphicon-log-in"></span>Logout (<?php echo Auth::user()->username;?>)</a></li>
                <?php
            }
            else
            {
                ?><li class="active"><a href="{{url('auth/login')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li class="active"><a href="{{url('auth/login')}}"><span class="glyphicon glyphicon-user"></span> SignUp</a></li>           
                <?php
            }
            ?>     
    </ul>
</nav>


@yield('content')

</body>
</html>

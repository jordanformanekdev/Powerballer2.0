<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Powerballer</title>
	<link rel="icon" type="image/png" href="images/ball.png">

	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="{{asset('css/main.css') }}" media="all" rel="stylesheet" type="text/css" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

</head>

<body>
<div class="container-fluid" style="padding: 1px;">

		<nav class="navbar navbar-default" style="margin: 0px; position: relative; padding: 0px;">
			<div class="container-fluid col-sm-2"  >
				<div class="navbar-header" style="font-style: italic; font-size: 22px; padding: 4px; ">POWERBALLER&nbsp&nbsp<span style="color: #777777; font-size: 12px;">2.0</span></div>
			</div>
            @if (Auth::check())
			    <div class="container-fluid col-sm-float-2" style="border-radius: 0px;  border: none;">
            @else
                <div class="container-fluid col-sm-float-2" style="border-radius: 0px; border-radius: 0px;  border: none;">
            @endif
                <div class="navbar-header">


				</div>

				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						&nbsp;
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="/auth/register"><i class="fa fa-btn fa-heart"></i>Register</a></li>
							<li><a href="/auth/login"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
						@else
							<li class="navbar-text"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->name }}</li>
							<li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
						@endif
					</ul>
				</div>
			</div>
		</nav>
	@if (Auth::check())
		<div class="container-fluid col-sm-2" style="padding: 0px; border-radius: 2px;">
			@include('smartBar.smartBar')
		</div>
	@endif
    @if (Auth::check())
	    <div class="container-fluid col-sm-offset-2" style="padding: 0px;">
    @else
        <div class="container">
    @endif
		@yield('content')
	</div>
</div>
</body>
</html>

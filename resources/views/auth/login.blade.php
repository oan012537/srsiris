<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Backoffice</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/core.cs')}}s" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.cs')}}s" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/lobibox.min.css') }}" rel="stylesheet"/>
	<link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{asset('assets/js/plugins/loaders/pace.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/core/libraries/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/ui/nicescroll.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/ui/drilldown.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{asset('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script type="text/javascript" src="{{asset('assets/js/core/app.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/pages/login.js')}}"></script>
	
	<script src="{{ asset('assets/js/lobibox.js') }}"></script>
    <script src="{{ asset('assets/js/demo.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container">
	@php
		$setting = DB::table('setting')->where('set_id',1)->first();
	@endphp
	<style>
		.navbar-inverse {
			background-color: {{$setting->set_nav}};
			//border-color: #164962;
		}
		
		.navbar-brand {
			color: {{$setting->set_navfont}} !important;
		}
		
		.navbar-inverse 
		.navbar-nav > li > a {
			color: {{$setting->set_navfont}} !important;
		}
		
		.navbar-default 
		.navbar-nav > li > a {
			color: {{$setting->set_menu}} !important;
		}
	</style>
	
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{url('/')}}">{{$setting->set_name}}</a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Advanced login -->
				<form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
					<div class="login-form">
						<div class="text-center">
							<img src="{{asset('assets/images/setting')}}/{{$setting->set_logo}}" class="img-responsive" alt="company logo">
							<h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback has-feedback-left">
							<input type="text" class="form-control input-lg" name="email" id="email" value="{{ old('email') }}" required autofocus>
							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
							<div class="form-control-feedback">
								<i class="icon-user text-muted"></i>
							</div>
						</div>
						
						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback has-feedback-left">
							<input type="password" class="form-control input-lg" name="password" id="password" required>
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>

						<div class="form-group login-options">
							<div class="row">
								<div class="col-sm-6">
									<label class="checkbox-inline">
										<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="styled">
										Remember
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn bg-blue btn-block btn-lg">Login <i class="icon-arrow-right14 position-right"></i></button>
						</div>	
					</div>
				</form>
				<!-- /advanced login -->

			</div>
			<!-- /main content -->
			<!-- Footer -->
					<div class="footer text-muted text-center">
						Copyright &copy; 2017. <a href="#">ORANGE TECHNOLOGY SOLUTION COMPANY LIMITED</a>
					</div>
					<!-- /footer -->
		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
</body>
</html>

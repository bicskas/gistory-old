<!doctype html>
<html lang="hu">
	<head>
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="{{ asset('/vendor/bootstrap/dist/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/vendor/bootstrap/dist/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/vendor/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/vendor/dropzone/dist/min/dropzone.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/vendor/Jcrop/css/Jcrop.min.css')}}">
		<link rel="stylesheet" href="{{ asset('/a/admin.css')}}">
		<title>Admin</title>
	</head>
	<body>
		@if (Auth::user())
		<header>
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle Navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{url('/admin')}}"><span class="glyphicon glyphicon-home"></span></a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li class="{{($aktiv_oldal == 'menu') ? 'active' : ''}}"><a href="/admin/menu">{{trans_choice('admin.menu', 2)}}</a></li>
							<li class="{{($aktiv_oldal == 'szoveg') ? 'active' : ''}}"><a href="/admin/szoveg">{{trans_choice('admin.szoveg', 2)}}</a></li>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							<li class="navbar-text">Belépve: <strong>{!! Auth::user()->email !!}</strong></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
								<ul class="dropdown-menu">
									<li><a href="/admin/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Kilépés</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		@endif
		<div id="main" role="main">
			<div id="container" class="container">
				@if ($errors->has())
				<div class="alert alert-danger alert-dismissible" role="alert" data-danger-fields="{{json_encode($errors->keys())}}">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if (Session::has('figyelmeztet'))
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('figyelmeztet') }}
				</div>
				@endif
				@if (Session::has('uzenet'))
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('uzenet') }}
				</div>
				@endif

				@yield('content')
			</div>
		</div>

		<div class="ajax_loader">
			<span class="glyphicon glyphicon-refresh icon-refresh-animate"></span>
		</div>

		<!-- Script -->
		<script src="{{ asset('/vendor/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{ asset('/vendor/jquery-ui/jquery-ui.min.js')}}"></script>
		<script src="{{ asset('/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
		<script src="{{ asset('/vendor/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
		<script src="{{ asset('/vendor/smalot-bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.hu.js') }}"></script>
		<script src="{{ asset('/vendor/dropzone/dist/min/dropzone.min.js')}}"></script>
		<script src="{{ asset('/vendor/Jcrop/js/Jcrop.min.js')}}"></script>
		<script src="{{ asset('/vendor/jquery-form/jquery.form.js')}}"></script>
		<script src="{{ asset('/vendor/ckeditor/ckeditor.js')}}"></script>
		<script src="{{ asset('/a/init.js') }}"></script>

	</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="stylesheet" type="text/css" href="/css/app.css">

	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		
		<!-- /.login-logo -->
		<div class="card">
			<div class="login-logo">
				<img src="/img/design/logos (2)/logo_transparent.png" class="rounded" width="150" height="150">
			</div>
			<div class="card-body login-card-body">
				
				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="input-group mb-3">
						<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope text-teal"></span>
							</div>
						</div>

						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="input-group mb-3">
						<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-key text-teal"></span>
							</div>
						</div>
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="row">
						<button type="submit" class="btn btn-success btn-block">Sign In</button>
					</div>
				</form>

			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<script type="text/javascript" src="/js/app.js"></script>

</body>
</html>

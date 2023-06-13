{{-- @extends('layout.auth')

@section('content')
<form action="{{ route('action-login') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
      <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" name="email" id="email">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-envelope"></span>
        </div>
      </div>
      @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
    <div class="input-group">
      <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
      @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
    <div class="row mt-3">
      <div class="col-12">
        <button type="submit" class="btn btn-primary btn-block">Login</button>
      </div>
    </div>
</form>
<div class="mt-2 text-center">
    <a href="" class="text-center">Daftar Akun</a>
</div>
@endsection --}}

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Halaman Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/vendor/select2/select2.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/auth/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('img/logo.png') }}" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="{{ route('action-login') }}" method="POST">
          @csrf

					<span class="login100-form-title">
						Prakerin SMK
					</span>

          @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
          @elseif(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
          @endif

					<div class="wrap-input100">
						<input class="input100 form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}" placeholder="Email" name="email" id="email">
						<span class="focus-input100"></span>
						<span class="symbol-input100 @error('email') mb-2 @enderror">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
            @error('email')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>

					<div class="wrap-input100">
						<input type="password" class="input100 form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password">
						<span class="focus-input100"></span>
						<span class="symbol-input100 @error('password') mb-2 @enderror">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
            @error('password')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Login
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="{{ route('register') }}">
							Buat Akun
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="{{ asset("vendor/auth/vendor/jquery/jquery-3.2.1.min.js") }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/auth/vendor/bootstrap/js/popper.min.js') }}"></script>
	<script src="{{ asset('vendor/auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/auth/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/auth/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/auth/js/main.js') }}"></script>

</body>
</html>
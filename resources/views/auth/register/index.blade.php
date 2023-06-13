<!DOCTYPE html>
<html lang="en">
<head>
	<title>Halaman Register</title>
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
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('img/logo.png') }}" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="{{ route('action-register') }}" method="POST">
          @csrf

					<span class="login100-form-title">
						Prakerin SMK
					</span>

          <div class="wrap-input100">
						<input class="input100 form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') }}" placeholder="Nama Lengkap" name="name" id="name">
						<span class="focus-input100"></span>
						<span class="symbol-input100 @error('name') mb-2 @enderror">
							<i class="fas fa-user" aria-hidden="true"></i>
						</span>
            @error('name')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>

          <div class="wrap-input100">
						<input class="input100 form-control @error('identity_number') is-invalid @enderror" type="text" value="{{ old('identity_number') }}" placeholder="Nomor Identitas (NIP/NISN)" name="identity_number" id="identity_number">
						<span class="focus-input100"></span>
						<span class="symbol-input100 @error('identity_number') mb-2 @enderror">
							<i class="fas fa-user" aria-hidden="true"></i>
						</span>
            @error('identity_number')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>
          <p class="text-danger mb-3"><small>* NISN : 10 Digit | NIP : 18 Digit</small></p>

          <div class="wrap-input100" id="teacher_position">
						<input class="input100 form-control @error('position') is-invalid @enderror" type="text" value="{{ old('position') }}" placeholder="Jabatan" name="position" id="position">
						<span class="focus-input100"></span>
						<span class="symbol-input100 @error('position') mb-2 @enderror">
							<i class="fas fa-user" aria-hidden="true"></i>
						</span>
            @error('position')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>

          <div class="wrap-input100">
			<select class="custom-select input100" name="class" id="class">
              @foreach ($class as $data)
                <option value="{{ $data->id }}">{{ "Kelas " . $data->grade . " - " . $data->Department->name }}</option>
              @endforeach
            </select>
            <span class="focus-input100"></span>
						<span class="symbol-input100 @error('class') mb-2 @enderror">
							<i class="fas fa-user" aria-hidden="true"></i>
						</span>
            @error('class')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>

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

          <div class="wrap-input100">
						<input type="password" class="input100 form-control @error('confirmation_password') is-invalid @enderror" placeholder="Konfirmasi Password" name="confirmation_password" id="confirmation_password">
						<span class="focus-input100"></span>
						<span class="symbol-input100 @error('confirmation_password') mb-2 @enderror">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
            @error('confirmation_password')
              <span class="invalid-feedback" role="alert">
                  <small>{{ $message }}</small>
              </span>
            @enderror
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Daftar
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="{{ route('login') }}">
							Sudah Punya Akun? Login
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
  <script>
    $(document).ready(function() {
      $("#student_class").hide();
      $("#teacher_position").hide();
  
      $('#identity_number').keyup(function() {
        var value = $(this).val();
        if(value.length == 18){
          $("#teacher_position").show();
        }else{
          $("#teacher_position").hide();
        }
      });
    });
  </script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/auth/js/main.js') }}"></script>

</body>
</html>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> Đăng ký</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/welcome.css') }}">
</head>
<body>
	<header class="header header-add">
		<div class="container">
			<div class="row justify-content-between">
				<div class=" col-3 float-left">
					<a href="/"><h5 class="header-title">Meohamhoc.com</h5></a>
				</div>
				<div class=" col-3 float-right">
					@guest
					<a href="/login">
						<button class="btn-login mr-2">Đăng nhập</button>
					</a>

					<a href="/register">
						<button class="btn-login">Đăng ký</button>
					</a>
					@else
					<button onclick="document.getElementById('logout').submit()" class="btn-login">Đăng xuất</button>
					<form id="logout" action="{{ route('logout') }}" method="post">
						{{ csrf_field()}}
					</form>
					@endguest
				</div>
			</div>
		</div>
	</header>

	<div class="contact" id="register">

		<div class="container">
			<div class="row justify-content-center">

				<div class="col-lg-6">
					<div class="contact_form_container">
						<div class="form_title text-center pb-3">Tạo tài khoản mới</div>
						<form action="{{ route('register') }}" method="POST" id="contact_form" class="contact_form">
							{{ csrf_field() }}
							<p class="text-center">Đăng ký với</p>
							<div class="w-100 text-center">
								<a href="/redirect/facebook" class="btn-fb">
									<i class="fa fa-facebook fa-lg " ></i>
									<span>Facebook</span>
								</a>
								<a href="/redirect/google" class="btn-gg" >
									<i class="fa fa-google fa-lg" ></i>
									<span>Google</span>
								</a>
							</div>
							<p class="text-center">hoặc</p>
							<div class="row contact_row">
								@if($errors->has('name') == 1)
								<div class="col-lg-12">
									<span class="font-italic text-danger">
										{{ $errors->first('name') }}
									</span>
								</div>
								@endif

								<div class="col-lg-12 contact_col">
									<input type="text" name="name" class="form_input" placeholder="Tên người dùng" required="required" value="{{ old('name') }}">
								</div>

								@if($errors->has('email') == 1)
								<div class="col-lg-12">
									<span class="font-italic text-danger">
										{{ $errors->first('email') }}
									</span>
								</div>
								@endif

								<div class="col-lg-12 contact_col">
									<input type="email" name="email" class="form_input" placeholder="Email" value="{{ old('email') }}" >
								</div>

								@if($errors->has('password') == 1)
								<div class="col-lg-12">
									<span class="font-italic text-danger">
										{{ $errors->first('password') }}
									</span>
								</div>
								@endif

								<div class="col-lg-12 contact_col">
									<input type="password" name="password" class="form_input" placeholder="Mật khẩu " required="required">
								</div>

								<div class="col-lg-12 contact_col">
									<input type="password" class="form_input" placeholder="Nhập lại mật khẩu " required="required" name="password_confirmation">
								</div>
								<div class="col text-center">
									<button type="submit" class="form_button trans_200">Đăng ký</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

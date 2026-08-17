@extends('layouts.grain-auth')

@section('title', 'Login')

@section('content')
<div class="container-fluid pb-5">

	<div class="row justify-content-md-center">
		<div class="card-wrapper col-12 col-md-4 mt-5">
			<div class="brand text-center mb-3">
				<a href="/" class="text-decoration-none d-inline-flex align-items-center">
					<img src="{{ asset('sehati.logo.png') }}" alt="Sehati Peduli Sesama" style="height: 48px; width: auto;" class="mr-2">
					<span class="h4 mb-0 font-weight-bold text-dark">Sehati Peduli Sesama</span>
				</a>
			</div>
			<div class="card">
				<div class="card-body">
					<h4 class="card-title mb-4">Login Admin</h4>

                    @include('components.notification')

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
						<div class="form-group">
							<label for="email">Email</label>
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required autofocus>
							@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group">
							<label for="password">Password</label>
							<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required>
							@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group">
							<div class="form-check">
							  <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
							  <label class="form-check-label" for="remember">Ingat Saya</label>
							</div>
						</div>

						<div class="form-group no-margin">
							<button type="submit" class="btn btn-primary btn-block">
								Masuk
							</button>
						</div>

						<div class="text-center mt-3 small">
							Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection
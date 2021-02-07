<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    <title>Forget password - {{ config('app.name') }}</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>{{ config('app.name') }}</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <form class="login-form" action="{{ route('password.update') }}" method="POST" role="form">
                @csrf
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Reset password</h3>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label class="control-label" for="email">{{ __('E-Mail Address') }}</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="Email address" required autocomplete="email" autofocus value="{{ $email ?? old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label" for="password">{{ __('Password') }}</label>
                    <input class="form-control @error('password') is-invalid @enderror"  type="password" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input class="form-control @error('password') is-invalid @enderror"  type="password" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i> {{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="{{ asset('backend/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('backend/js/popper.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/main.js') }}"></script>
<script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
</body>
</html>


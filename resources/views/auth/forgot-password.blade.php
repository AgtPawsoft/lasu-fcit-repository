<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LASU FCIT Repository</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="text-white text-center py-4" style="background-color:#006400; border-radius: 5px 5px 0 0;">
                    <h4 class="fw-bold mb-0">LASU FCIT Repository</h4>
                    <small>Reset your password</small>
                </div>
                <div class="card-body p-4">

                    <p class="text-muted mb-4">Forgot your password? No problem. Enter your email address and we'll send you a password reset link.</p>

                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            Send Password Reset Link
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Remember your password?
                                <a href="{{ route('login') }}" class="text-success">Login here</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
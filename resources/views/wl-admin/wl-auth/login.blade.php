@extends('wl-admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">

            <div class="card auth-card">

                <div class="auth-header">
                    <div class="auth-logo">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <h3 class="fw-bold">Welcome Back</h3>
                    <p class="text-muted">Sign in to your account</p>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('admin.login.authentication')}}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password"
                                    required
                                >

                                <span
                                    class="input-group-text password-toggle"
                                    onclick="togglePassword('password','passwordIcon')"
                                >
                                    <i id="passwordIcon" class="bi bi-eye"></i>
                                </span>

                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="remember"
                                    name="remember"
                                >
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-login w-100">
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
        }

        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,.15);
            overflow: hidden;
        }

        .auth-header {
            background: #fff;
            text-align: center;
            padding: 30px 20px 10px;
        }

        .auth-logo {
            width: 80px;
            height: 80px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
        }

        .btn-login {
            height: 50px;
            border-radius: 10px;
            font-weight: 600;
        }

        .password-toggle {
            cursor: pointer;
        }

        .card-body {
            padding: 30px;
        }
    </style>
@endsection
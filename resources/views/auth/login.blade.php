@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 p-4 bg-white rounded">
                <h3 class="fw-bold mb-3 text-center">{{ auto_translate('Welcome Back') }}</h3>

                @if($errors->any())
                    <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ auto_translate('Email Address') }}</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ auto_translate('Password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold mb-3">{{ auto_translate('Sign In') }}</button>

                    <div class="text-center mb-3 text-muted small">{{ auto_translate('or') }}</div>

                    <a href="{{ route('auth.google') }}" class="btn btn-outline-dark w-100 fw-bold mb-2">
                        <i class="fa-brands fa-google me-2 text-danger"></i> {{ auto_translate('Continue with Google') }}
                    </a>
                </form>
                <div class="text-center mt-3">
                    <p class="small text-muted mb-0">{{ auto_translate("Don't have an account?") }} <a href="{{ route('register') }}">{{ auto_translate('Register') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
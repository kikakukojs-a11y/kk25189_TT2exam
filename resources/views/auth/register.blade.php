@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 p-4 bg-white rounded">
                <h3 class="fw-bold mb-3 text-center">{{ auto_translate('Create Account') }}</h3>

                @if($errors->any())
                    <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ auto_translate('Full Name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ auto_translate('Email Address') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ auto_translate('Password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ auto_translate('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold">{{ auto_translate('Register') }}</button>
                </form>
                <div class="text-center mt-3">
                    <p class="small text-muted mb-0">{{ auto_translate('Already have an account?') }} <a href="{{ route('login') }}">{{ auto_translate('Sign In') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
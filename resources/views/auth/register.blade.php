@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 p-4 bg-white rounded">
                <h3 class="fw-bold mb-3 text-center">{{ __('Create Account') }}</h3>

                @if($errors->any())
                    <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ __('Full Name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold">{{ __('Register') }}</button>
                </form>
                <div class="text-center mt-3">
                    <p class="small text-muted mb-0">{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
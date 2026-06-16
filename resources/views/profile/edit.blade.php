@extends('layouts.app')

@section('content')
<div class="row gap-4 justify-content-center">
    <div class="col-md-8 card">
        <h3 class="fw-bold text-dark ">Profile Information</h3>
        <p class="text-muted small">Update your account's profile details and email address info.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="mb-4">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

        <div class="p-3">
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to permanently delete your account?');">
                @csrf
                @method('delete')
                <button type="submit" class="btn text-danger bg-light">Delete Account</button>
            </form>
        </div>

    </div>
</div>
@endsection
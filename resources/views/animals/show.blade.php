@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <div class="mb-3">
        <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">← {{ __('Back to All Animals') }}</a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            @if($animal->image)
                <img src="{{ asset('storage/' . $animal->image) }}" alt="{{ __('Photo of') }} {{ $animal->name }}" class="img-fluid">
            @else
                <div class="bg-light p-5 text-center text-muted mb-3">{{ __('No Photo Available') }}</div>
            @endif
            
            <h1>{{ $animal->name }} <small class="text-muted">({{ __('ID: #') }}{{ $animal->id }})</small></h1>
            <p>{{ __('Category:') }} <strong>{{ $animal->category->name ?? __('Uncategorized') }}</strong></p>
            
            <h5 class="mt-4">{{ __('Characteristics:') }}</h5>
            @if($animal->characteristics && $animal->characteristics->count() > 0)
                <div>
                    @foreach($animal->characteristics as $characteristic)
                        <span class="text-dark">{{ $characteristic->name }}</span><i>, </i>
                    @endforeach
                </div>
            @else
                <p class="text-muted small">{{ __('No characteristics tags specified for this animal profile.') }}</p>
            @endif
        </div>

        <div class="col-md-6 mb-4">
            <h2>{{ __('Adopt') }} {{ $animal->name }}</h2>
            <p class="text-muted">{{ __('Write a motivation letter to adopt this animal.') }}</p>
            
            <form action="{{ route('applications.store') }}" method="POST">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $animal->id }}">

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('Adoption intent') }}</label>
                    <textarea name="notes" id="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" required>{{ old('notes') }}</textarea>
                    
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn w-100 text-success">{{ __('Submit My Application') }}</button>
            </form>

            @auth
                @if(Auth::user()->role === 'Admin')
                    <div class="border p-3 rounded bg-light">
                        <strong>{{ __('Admin Controls:') }}</strong>
                        <div class="mt-2">
                            <a href="{{ route('admin.animals.edit', $animal->id) }}" class="btn btn-sm">{{ __('Edit Profile') }}</a>

                            <form action="{{ route('admin.animals.destroy', $animal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Soft-delete this profile?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger">{{ __('Delete Profile') }}</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
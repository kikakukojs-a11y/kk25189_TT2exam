@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <div class="mb-3">
        <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">← {{ auto_translate('Back to All Animals') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ auto_translate(session('success')) }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">


            @if($animal->image)
    <img src="{{ Storage::url($animal->image) }}" alt="{{ $animal->name }}" class="img-fluid w-100 object-fit-cover" style="max-height: 450px;">
@else
    <div class="bg-light text-center py-5 text-muted rounded border mb-3">
        {{ auto_translate('No Image Available') }}
    </div>
@endif
            
            <h1>{{ $animal->name }} <small class="text-muted">({{ auto_translate('ID: #') }}{{ $animal->id }})</small></h1>
            <p>{{ auto_translate('Category:') }} <strong>{{ auto_translate($animal->category->name ?? 'Uncategorized') }}</strong></p>
            
            <h5 class="mt-4">{{ auto_translate('Characteristics:') }}</h5>
            @if($animal->characteristics && $animal->characteristics->count() > 0)
                <div>
                    @foreach($animal->characteristics as $characteristic)
                        <span class="badge bg-dark-subtle text-dark me-1 p-2">{{ auto_translate($characteristic->name) }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-muted small">{{ auto_translate('No characteristics tags specified for this animal profile.') }}</p>
            @endif
        </div>

        <div class="col-md-6 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="m-0">{{ auto_translate('Adopt') }} {{ $animal->name }}</h2>
                
                @auth
                    @php
                        $isFavorited = Auth::user()->favorites->contains($animal->id);
                    @endphp
                    <form action="{{ route('favorites.toggle', $animal) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn {{ $isFavorited ? 'text-danger' : 'text-success' }}">
                            {{ $isFavorited ? auto_translate('Remove from Favorites')  : auto_translate('Add to Favorites')  }}
                        </button>
                    </form>
                @endauth
            </div>

            <p class="text-muted">{{ auto_translate('Write a motivation letter to adopt this animal.') }}</p>
            
            <form action="{{ route('applications.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $animal->id }}">

                <div class="mb-3">
                    <label for="notes" class="form-label font-weight-bold">{{ auto_translate('Adoption intent') }}</label>
                    <textarea name="notes" id="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" required>{{ old('notes') }}</textarea>
                    
                    @error('notes')
                        <div class="invalid-feedback">{{ auto_translate($message) }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">{{ auto_translate('Submit My Application') }}</button>
            </form>

            @auth
                @if(Auth::user()->role === 'Admin')
                    <div class="border p-3 rounded bg-light">
                        <strong class="text-secondary d-block mb-2">{{ auto_translate('Admin Controls:') }}</strong>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.animals.edit', $animal->id) }}" class="btn btn-sm text-primary">{{ auto_translate('Edit Profile') }}</a>

                            <form action="{{ route('admin.animals.destroy', $animal->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('{{ auto_translate('Soft-delete this profile?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-danger">{{ auto_translate('Delete Profile') }}</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
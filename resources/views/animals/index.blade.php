@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <div class="mb-4">
        <h1>{{ __('Find your new pet!') }}</h1>
        <p class="text-muted fs-5">{{ __('Browse our catalogue of animals currently looking for a home. Filter by species or breed.') }}</p>
    </div>

    <div class="card p-3 mb-4 bg-light">
        <form method="GET" action="{{ route('animals.index') }}" class="row g-3 align-items-end">
            
            <div class="col-md-5">
                <label for="search" class="form-label small fw-bold">{{ __('Search by Name or Breed') }}</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="{{ __('e.g., Buddy, Golden Retriever...') }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label for="species" class="form-label small fw-bold">{{ __('Filter by Species') }}</label>
                <select name="species" id="species" class="form-select">
                    <option value="">{{ __('All Species') }}</option>
                    @if(isset($all_species))
                        @foreach($all_species as $spec)
                            <option value="{{ $spec->id }}" {{ request('species') == $spec->id ? 'selected' : '' }}>
                                {{ ucfirst($spec->name) }}
                            </option>
                        @endforeach
                    @else
                        <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>{{ __('Dog') }}</option>
                        <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>{{ __('Cat') }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">{{ __('Apply Filters') }}</button>
                <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">{{ __('Clear') }}</a>
            </div>
        </form>
    </div>

    <div class="py-2">
        @if(!isset($animals) || $animals->isEmpty())
            <div class="text-center py-5">
                <h3 class="text-muted">{{ __('No animals found') }}</h3>
                <p class="text-muted">{{ __('Try changing filters or typing a different breed/name.') }}</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($animals as $animal)
                    <div class="col">
                        <div class="card h-100">
                    
                            @if($animal->image)
                                <img src="{{ asset('storage/' . $animal->image) }}" class="card-img-top" alt="{{ __('Photo of') }} {{ $animal->name }}">
                            @else
                                <div class="bg-light text-center py-5 border-bottom text-muted">{{ __('No Image Available') }}</div>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $animal->name }}</h5>
                                <p class="card-text text-muted mb-3">
                                    <span class="badge bg-secondary me-1">
                                        {{ ucfirst($animal->species ?? $animal->category->name ?? __('Animal')) }}
                                    </span>
                                    {{ $animal->breed ?? __('Mixed Breed') }}
                                </p>
                                <a href="{{ route('animals.show', $animal->id) }}" class="btn btn-outline-primary w-100">
                                    {{ __('View Profile Details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
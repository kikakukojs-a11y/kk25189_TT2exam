@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <div class="mb-4">
        <h1>{{ auto_translate('Find your new pet!') }}</h1>
        <p class="text-muted fs-5">{{ auto_translate('Browse our catalogue of animals currently looking for a home. Filter by species or breed.') }}</p>
    </div>

    <div class="card p-3 mb-4 bg-light">
        <form method="GET" action="{{ route('animals.index') }}" class="row g-3 align-items-end">
            
            <div class="col-md-5">
                <label for="search" class="form-label small fw-bold">{{ auto_translate('Search by Name or Breed') }}</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"  class="form-control">
            </div>

            <div class="col-md-4">
                <label for="species" class="form-label small fw-bold">{{ auto_translate('Filter by Species') }}</label>
                <select name="species" id="species" class="form-select">
                    <option value="">{{ auto_translate('All Species') }}</option>
                    @if(isset($all_species))
                        @foreach($all_species as $spec)
                            <option value="{{ $spec->id }}" {{ request('species') == $spec->id ? 'selected' : '' }}>
                                {{ ucfirst($spec->name) }}
                            </option>
                        @endforeach
                    @else
                        <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>{{ auto_translate('Dog') }}</option>
                        <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>{{ auto_translate('Cat') }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">{{ auto_translate('Apply Filters') }}</button>
                <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">{{ auto_translate('Clear') }}</a>
            </div>
        </form>
    </div>

    <div class="py-2">
        @if(!isset($animals) || $animals->isEmpty())
            <div class="text-center py-5">
                <h3 class="text-muted">{{ auto_translate('No animals found') }}</h3>
                <p class="text-muted">{{ auto_translate('Try changing filters or typing a different breed/name.') }}</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($animals as $animal)
                    <div class="col">
                        <div class="card h-100">
                    
        @if($animal->image)
            <img src="{{ Storage::url($animal->image) }}" alt="{{ $animal->name }}" class="card-img-top object-fit-cover" style="height: 250px;">
        @else
        <div class="bg-light text-center text-muted">
            <i class="bi bi-image d-block mb-2"></i>
            {{ auto_translate('No Image Available') }}
        </div>
        @endif

                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $animal->name }}</h5>
                                <p class="card-text text-muted mb-3">
                                    <span class="badge bg-secondary me-1">
                                        {{ ucfirst($animal->species ?? $animal->category->name ?? auto_translate('Animal')) }}
                                    </span>
                                    {{ $animal->breed}}
                                </p>
                                <a href="{{ route('animals.show', $animal->id) }}" class="btn btn-outline-primary w-100">
                                    {{ auto_translate('View Profile Details') }}
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
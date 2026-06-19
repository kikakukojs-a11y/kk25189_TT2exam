@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ auto_translate('My Favorites') }} ({{ $animals->count() }})</h1>

    @if($animals->isEmpty())
        <div class="text-center py-5 bg-light rounded border">
            <p class="text-muted fs-5 mb-3">{{ auto_translate('You have no saved animals yet.') }}</p>
            <a href="{{ route('animals.index') }}" class="btn btn-primary">
                {{ auto_translate('Browse Animals') }}
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @foreach($animals as $animal)
                <div class="col">
                    <div class="card h-100 shadow-sm">

        @if($animal->image)
            <img src="{{ Storage::url($animal->image) }}" alt="{{ $animal->name }}" class="card-img-top object-fit-cover" style="height: 250px;">
        @else
        <div class="bg-light text-center text-muted">
            <i class="bi bi-image d-block mb-2"></i>
            {{ auto_translate('No Image Available') }}
        </div>
        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $animal->name }}</h5>
                            <p class="card-text text-muted small mb-2">
                                <strong>{{ auto_translate('Category:') }}</strong> {{ $animal->category->name }}
                            </p>
                            <p class="card-text text-truncate">{{ $animal->description }}</p>
                        </div>


                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a href="{{ route('animals.show', $animal) }}" class="btn btn-sm btn-link text-decoration-none">
                                {{ auto_translate('View Details') }}
                            </a>

                            <form action="{{ route('favorites.toggle', $animal) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm ">
                                    {{ auto_translate('Remove') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ __('Edit Profile') }}: {{ $animal->name }}</h2>

    <form action="{{ route('admin.animals.update', $animal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">{{ __('Animal Name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $animal->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Category') }}</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $animal->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Breed') }}</label>
            <input type="text" name="breed" class="form-control" value="{{ old('breed', $animal->breed) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Age (Years)') }}</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $animal->age) }}" required min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Description') }}</label>
            <textarea name="description" rows="4" class="form-control" required>{{ old('description', $animal->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Characteristics') }}</label>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    {{ __('Select Characteristics') }}
                </button>
                <div class="dropdown-menu p-3 w-100">
                    @foreach($characteristics as $characteristic)
                        <div class="form-check">
                            <input type="checkbox" name="characteristics[]" value="{{ $characteristic->id }}" id="characteristic_{{ $characteristic->id }}" class="form-check-input" {{ isset($animal) && $animal->characteristics->contains($characteristic->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="characteristic_{{ $characteristic->id }}">
                                {{ $characteristic->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">{{ __('Animal Profile Photo') }}</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <div class="form-text text-muted small">{{ __('Formats: JPEG, PNG, JPG, WEBP (Max 2MB).') }}</div>
            @error('image')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
    </form>
</div>
@endsection
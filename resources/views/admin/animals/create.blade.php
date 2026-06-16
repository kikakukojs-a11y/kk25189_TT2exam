@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ __('Create Animal Profile') }}</h2>

    <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Species') }}</label>
            <select name="category_id" class="form-control" required>
                <option value="">{{ __('Choose species...') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Animal Breed') }}</label>
            <input type="text" name="breed" value="{{ old('breed') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Age') }}</label>
            <input type="number" name="age" min="0" value="{{ old('age') }}" class="form-control" required>
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
                            <input type="checkbox" name="characteristics[]" value="{{ $characteristic->id }}" id="characteristic_{{ $characteristic->id }}" class="form-check-input" {{ is_array(old('characteristics')) && in_array($characteristic->id, old('characteristics')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="characteristic_{{ $characteristic->id }}">
                                {{ $characteristic->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Photo') }}</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <div class="form-text text-muted small">{{ __('Formats: JPEG, PNG, JPG, WEBP (Max 2MB).') }}</div>
            @error('image')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">{{ __('Description') }}</label>
            <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">{{ __('Publish Profile') }}</button>
            <a href="{{ route('animals.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
@endsection
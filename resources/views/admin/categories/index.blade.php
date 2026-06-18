@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">{{ __('Add New Species') }}</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Species Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Add the Species') }}</button>
    </form>

    <h2 class="mb-3">{{ __('Current Active Species') }}</h2>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Species Name') }}</th>
                <th>{{ __('Total Profiles') }}</th>
                <th class="text-end">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->animals_count }} {{ __('animals') }}</td>
                <td class="text-end">
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm text-danger">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
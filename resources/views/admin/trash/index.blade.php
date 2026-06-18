@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ __('Trash of Records') }}</h2>
        <a href="{{ route('animals.index') }}" class="btn btn-secondary btn-sm">{{ __('Back to Catalogue') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h4 class="mt-4 mb-2">{{ __('Deleted Animal Profiles') }}</h4>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Classification') }}</th>
                <th>{{ __('Animal Breed') }}</th>
                <th>{{ __('Deleted At') }}</th>
                <th class="text-end">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deletedAnimals as $animal)
            <tr>
                <td>{{ $animal->name }}</td>
                <td>{{ $animal->category->name ?? __('Unassigned') }}</td>
                <td>{{ $animal->breed }}</td>
                <td>{{ $animal->deleted_at->format('Y-m-d H:i') }}</td>
                <td class="text-end">
                    <form action="{{ route('admin.trash.animals.restore', $animal->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">{{ __('Restore') }}</button>
                    </form>
                    <form action="{{ route('admin.trash.animals.force-delete', $animal->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">{{ __('No deleted animal profiles found.') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="mt-5 mb-2">{{ __('Deleted Species Categories') }}</h4>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Species Name') }}</th>
                <th>{{ __('Deleted At') }}</th>
                <th class="text-end">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deletedCategories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->deleted_at->format('Y-m-d H:i') }}</td>
                <td class="text-end">
                    <form action="{{ route('admin.trash.categories.restore', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm text-success">{{ __('Restore') }}</button>
                    </form>
                    <form action="{{ route('admin.trash.categories.force-delete', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm text-danger">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">{{ __('No deleted species categories found.') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
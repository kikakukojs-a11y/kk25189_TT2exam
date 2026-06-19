@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ auto_translate('Manage Animal Applications') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>{{ auto_translate('Date') }}</th>
                <th>{{ auto_translate('Applicant') }}</th>
                <th>{{ auto_translate('Animal') }}</th>
                <th>{{ auto_translate('Notes') }}</th>
                <th>{{ auto_translate('Status') }}</th>
                <th>{{ auto_translate('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr>
                    <td>{{ $application->created_at ? $application->created_at->format('Y-m-d H:i') : ($application->date ?? auto_translate('N/A')) }}</td>
                    <td>{{ $application->user->name ?? auto_translate('User #') . $application->user_id }}</td>
                    <td>{{ $application->animal->name ?? auto_translate('Animal #') . $application->animal_id }}</td>
                    



                    <td>

                        @php 
                            $displayStatus = $application->status; 
                            $lowerStatus = strtolower($application->getRawOriginal('status'));
                        @endphp
                        <span class="badge {{ $lowerStatus === 'approved' ? 'bg-success' : ($lowerStatus === 'rejected' ? 'bg-danger' : 'text-dark') }}">
                            {{ $displayStatus }}
                        </span>
                    </td>
                    <td>
                        @if(strtolower($application->getRawOriginal('status')) === 'pending')
                            <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Approved">
                                <button type="submit" class="btn btn-sm btn-success">{{ auto_translate('Accept') }}</button>
                            </form>

                            <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Decline this application?') }}');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Rejected">
                                <button type="submit" class="btn btn-sm btn-danger">{{ auto_translate('Decline') }}</button>
                            </form>
                        @else
                            <span class="text-muted small">{{ auto_translate('Processed') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">{{ auto_translate('No applications found.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
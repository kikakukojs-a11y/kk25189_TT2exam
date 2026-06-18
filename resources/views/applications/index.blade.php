@extends('layouts.app')

@section('content')
<div class="row card shadow-sm border-0 p-4 rounded-3">
    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold m-0 text-dark"><i class="fa-solid fa-file-lines text-primary me-2"></i>{{ __('My Adoption Applications') }}</h2>
    </div>
    <hr class="text-muted">
    
    <div class="alert alert-info border-0 shadow-sm" role="alert">
        <i class="fa-solid fa-circle-info me-2"></i>{{ __("You haven't submitted any adoption applications yet. Explore our directory to apply!") }}
    </div>
</div>
@endsection
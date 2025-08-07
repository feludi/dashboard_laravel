@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center">
        <div class="error-illustration mb-4">
            <i class="fas fa-exclamation-triangle fa-5x text-danger opacity-50"></i>
        </div>
        
        <h1 class="display-1 fw-bold text-danger">500</h1>
        <h2 class="h4 mb-3">Internal Server Error</h2>
        <p class="text-muted mb-4">
            Something went wrong on our servers. We're working to fix this issue. Please try again later.
        </p>
        
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('dashboard.index') }}" class="btn btn-primary">
                <i class="fas fa-home me-2"></i>
                Go to Dashboard
            </a>
            <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                <i class="fas fa-redo me-2"></i>
                Try Again
            </button>
        </div>
    </div>
</div>
@endsection

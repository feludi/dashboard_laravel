@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('page-actions')
@if($user->id > 0)
    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-edit me-1"></i>Edit Profile
    </a>
@else
    <div class="alert alert-info alert-sm mb-0 py-1 px-2" style="font-size: 12px;">
        <i class="fas fa-info-circle me-1"></i>Login with database account to edit profile
    </div>
@endif
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Picture Card -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="{{ $user->avatar_url }}" 
                         alt="Avatar" 
                         class="rounded-circle img-fluid" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text text-muted">{{ $user->email }}</p>
                @if($user->bio)
                    <p class="card-text">{{ $user->bio }}</p>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="mb-1 text-primary">{{ \App\Models\Foreigner::count() }}</h4>
                            <small class="text-muted">Total Records</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-1 text-success">{{ \App\Models\Foreigner::whereDate('created_at', today())->count() }}</h4>
                        <small class="text-muted">Today</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Profile Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Profile Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $user->name }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $user->email }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $user->phone ?? 'Not provided' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Bio</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $user->bio ?? 'Not provided' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Joined</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        @if($user->id > 0)
                            {{ \App\Helpers\DateHelper::formatIndonesian($user->created_at, 'd F Y') }}
                            <small class="text-muted">({{ \App\Helpers\DateHelper::diffForHumansIndonesian($user->created_at) }})</small>
                        @else
                            <span class="text-muted">User Session</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity (only for admins) -->
        @php
            $currentUser = \App\Http\Controllers\AuthController::user();
        @endphp
        @if($currentUser && is_object($currentUser) && $currentUser->canViewForeignerList())
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Activity
                </h6>
            </div>
            <div class="card-body">
                @php
                    $recentForeigners = \App\Models\Foreigner::latest()->take(5)->get();
                @endphp
                
                @if($recentForeigners->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentForeigners as $foreigner)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">{{ $foreigner->first_name }} {{ $foreigner->last_name }}</h6>
                                    <small class="text-muted">
                                        Added {{ \App\Helpers\DateHelper::diffForHumansIndonesian($foreigner->created_at) }}
                                    </small>
                                </div>
                                <a href="{{ route('foreigners.show', $foreigner) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No records added yet</p>
                    </div>
                @endif
            </div>
        </div>
        @else
        <!-- Operator Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if($currentUser && is_object($currentUser) && $currentUser->canAddForeigners())
                    <div class="col-md-6">
                        <a href="{{ route('foreigners.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>
                            Add New Record
                        </a>
                    </div>
                    @endif
                    @if($currentUser && is_object($currentUser) && $currentUser->canImportForeigners())
                    <div class="col-md-6">
                        <a href="{{ route('imports.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-file-import me-2"></i>
                            Import Data
                        </a>
                    </div>
                    @endif
                </div>
                <hr class="my-3">
                <div class="text-muted">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        As an operator, you can add new records and import data but cannot view or edit existing records.
                    </small>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

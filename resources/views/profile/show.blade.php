@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-circle me-2"></i>
        Profil Saya
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if($user->id > 0)
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                Edit Profil
            </a>
        @else
            <div class="alert alert-info mb-0">
                <small><i class="fas fa-info-circle me-1"></i>Login dengan akun database untuk edit profil</small>
            </div>
        @endif
    </div>
</div>

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
                    Statistik
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="mb-1 text-primary">{{ \App\Models\Foreigner::count() }}</h4>
                            <small class="text-muted">Total Data</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-1 text-success">{{ \App\Models\Foreigner::whereDate('created_at', today())->count() }}</h4>
                        <small class="text-muted">Hari Ini</small>
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
                    Informasi Profil
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nama Lengkap</h6>
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
                        <h6 class="mb-0">Telepon</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $user->phone ?? 'Belum diisi' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Bio</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{ $user->bio ?? 'Belum diisi' }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Bergabung</h6>
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

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Aktivitas Terbaru
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
                                        Ditambahkan {{ \App\Helpers\DateHelper::diffForHumansIndonesian($foreigner->created_at) }}
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
                        <p>Belum ada data yang ditambahkan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

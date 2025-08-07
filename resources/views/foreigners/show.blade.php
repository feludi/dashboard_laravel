@extends('layouts.app')

@section('title', 'View Foreigner Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user me-2"></i>
        {{ $foreigner->first_name }} {{ $foreigner->last_name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            @php
                $currentUser = \App\Http\Controllers\AuthController::user();
            @endphp
            @if($currentUser && is_object($currentUser) && $currentUser->canEditForeigners())
            <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                Edit
            </a>
            @endif
            @if($currentUser && is_object($currentUser) && $currentUser->canViewForeignerList())
            <a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to List
            </a>
            @else
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Dashboard
            </a>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-circle me-2"></i>
                    Personal Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">First Name:</th>
                                <td>{{ $foreigner->first_name }}</td>
                            </tr>
                            <tr>
                                <th>Last Name:</th>
                                <td>{{ $foreigner->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td>
                                    {{ \App\Helpers\DateHelper::formatIndonesian($foreigner->date_of_birth, 'd F Y') ?: 'Not specified' }}
                                    @if($foreigner->date_of_birth)
                                        <small class="text-muted">({{ $foreigner->date_of_birth->age }} years old)</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td>
                                    <i class="fas fa-{{ $foreigner->gender === 'male' ? 'mars' : ($foreigner->gender === 'female' ? 'venus' : 'genderless') }} me-1"></i>
                                    {{ ucfirst($foreigner->gender) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Nationality:</th>
                                <td>
                                    <span class="d-flex align-items-center">
                                        <span class="flag-emoji" style="font-size: 20px; margin-right: 8px;">{{ \App\Helpers\CountryHelper::getFlagEmoji($foreigner->nationality) }}</span>
                                        {{ $foreigner->nationality }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Passport Number:</th>
                                <td>
                                    <code>{{ $foreigner->passport_number ?: 'Not provided' }}</code>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>
                                    @if($foreigner->phone)
                                        <i class="fas fa-phone me-1"></i>
                                        <a href="tel:{{ $foreigner->phone }}">{{ $foreigner->phone }}</a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    @if($foreigner->email)
                                        <i class="fas fa-envelope me-1"></i>
                                        <a href="mailto:{{ $foreigner->email }}">{{ $foreigner->email }}</a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Residence Permit Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-id-card me-2"></i>
                    Residence Permit Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Residence Permit Type:</th>
                                <td>
                                    <span class="badge bg-info">{{ $foreigner->residence_permit_type }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Residence Permit Status:</th>
                                <td>
                                    @php
                                        $isExpired = $foreigner->residence_permit_expiry_date && now()->isAfter($foreigner->residence_permit_expiry_date);
                                        $permitStatus = $isExpired ? 'Expired' : 'Active';
                                        $badgeColor = $isExpired ? 'danger' : 'success';
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">
                                        {{ $permitStatus }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Entry Date:</th>
                                <td>
                                    @if($foreigner->entry_date)
                                        {{ \App\Helpers\DateHelper::formatIndonesian($foreigner->entry_date, 'd F Y') }}
                                        <small class="text-muted">({{ \App\Helpers\DateHelper::diffForHumansIndonesian($foreigner->entry_date) }})</small>
                                    @else
                                        <span class="text-muted">Not specified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Residence Permit Expiry Date:</th>
                                <td>
                                    @if($foreigner->residence_permit_expiry_date)
                                        {{ \App\Helpers\DateHelper::formatIndonesian($foreigner->residence_permit_expiry_date, 'd F Y') }}
                                        @if($foreigner->residence_permit_expiry_date->isPast())
                                            <span class="badge bg-danger ms-1">EXPIRED</span>
                                        @elseif(floor($foreigner->residence_permit_expiry_date->diffInDays()) < 30)
                                            <span class="badge bg-warning ms-1">{{ \App\Helpers\DateHelper::daysRemainingIndonesian($foreigner->residence_permit_expiry_date) }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-success">Permanent</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Location Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Current Address</h6>
                        <p class="text-muted">
                            {{ $foreigner->current_address ?: 'No address provided' }}
                        </p>
                        
                        <h6>Administrative Location</h6>
                        <div class="mb-2">
                            <strong>Kota/Kabupaten:</strong>
                            <p class="mb-1">{{ $foreigner->city ?: 'Not specified' }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Kecamatan:</strong>
                            <p class="mb-1">{{ $foreigner->state_province ?: 'Not specified' }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Kelurahan/Desa:</strong>
                            <p class="mb-1">{{ $foreigner->village ?: 'Not specified' }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Postal Code:</strong>
                            <p class="mb-1">{{ $foreigner->postal_code ?: 'Not specified' }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Country:</strong>
                            <p class="mb-1">{{ $foreigner->country ?: 'Not specified' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($foreigner->latitude && $foreigner->longitude)
                            <h6>Coordinates</h6>
                            <p>
                                <strong>Latitude:</strong> {{ $foreigner->latitude }}<br>
                                <strong>Longitude:</strong> {{ $foreigner->longitude }}
                            </p>
                            <div id="map" style="height: 200px; border-radius: 8px;"></div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                <p>No location coordinates available</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($foreigner->emergency_contact)
                    <hr>
                    <h6>Emergency Contact</h6>
                    <p class="text-muted">{{ $foreigner->emergency_contact }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Photo -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Foto WNA
                </h6>
            </div>
            <div class="card-body text-center">
                @if($foreigner->photo)
                    <img src="{{ asset('uploads/photos/' . $foreigner->photo) }}" 
                         class="img-fluid rounded" 
                         alt="Photo of {{ $foreigner->full_name }}"
                         style="max-height: 250px; width: 100%; object-fit: cover;">
                    <div class="mt-2">
                        <small class="text-muted">{{ $foreigner->photo }}</small>
                    </div>
                @else
                    <div class="text-center p-4">
                        <i class="fas fa-user-circle fa-5x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada foto</p>
                        @if($currentUser && is_object($currentUser) && $currentUser->canEditForeigners())
                        <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-camera me-1"></i>
                            Tambah Foto
                        </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($currentUser && is_object($currentUser) && $currentUser->canEditForeigners())
                    <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Information
                    </a>
                    @endif
                    @if($currentUser && is_object($currentUser) && $currentUser->canDeleteForeigners())
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>
                        Delete Record
                    </button>
                    @endif
                    @if(!($currentUser && is_object($currentUser) && $currentUser->canEditForeigners()) && !($currentUser && is_object($currentUser) && $currentUser->canDeleteForeigners()))
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>You don't have permission to modify this record</small>
                    </div>
                    @endif
                        <i class="fas fa-trash me-2"></i>
                        Delete Record
                    </button>
                </div>
            </div>
        </div>

        <!-- Record Information -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Record Information
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th>Created:</th>
                        <td class="text-muted">{{ \App\Helpers\DateHelper::formatIndonesian($foreigner->created_at, 'd F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated:</th>
                        <td class="text-muted">{{ \App\Helpers\DateHelper::formatIndonesian($foreigner->updated_at, 'd F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Record ID:</th>
                        <td><code>{{ $foreigner->id }}</code></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal (only for users with delete permissions) -->
@if($currentUser && is_object($currentUser) && $currentUser->canDeleteForeigners())
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $foreigner->first_name }} {{ $foreigner->last_name }}</strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('foreigners.destroy', $foreigner) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($foreigner->latitude && $foreigner->longitude)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix Leaflet marker icon paths
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            shadowRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
        });
        
        const map = L.map('map').setView([{{ $foreigner->latitude }}, {{ $foreigner->longitude }}], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        L.marker([{{ $foreigner->latitude }}, {{ $foreigner->longitude }}])
            .addTo(map)
            .bindPopup('<strong>{{ $foreigner->first_name }} {{ $foreigner->last_name }}</strong><br>{{ $foreigner->current_address }}')
            .openPopup();
    });
</script>
@endif
@endpush

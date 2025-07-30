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
            <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                Edit
            </a>
            <a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to List
            </a>
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
                                    {{ \App\Helpers\DateHelper::formatIndonesian($foreigner->date_of_birth, 'd F Y') ?: 'Tidak ditentukan' }}
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
                                        <img src="{{ \App\Helpers\CountryHelper::getFlagUrl($foreigner->nationality, '24') }}" 
                                             alt="{{ $foreigner->nationality }} flag" 
                                             class="nationality-flag me-2"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                                             style="width: 24px; height: 16px; border-radius: 2px; border: 1px solid #ddd; object-fit: cover;">
                                        <span class="flag-emoji" style="display:none; font-size: 16px; margin-right: 8px;">{{ \App\Helpers\CountryHelper::getFlagEmoji($foreigner->nationality) }}</span>
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

        <!-- Visa Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-id-card me-2"></i>
                    Visa Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Visa Type:</th>
                                <td>
                                    <span class="badge bg-info">{{ $foreigner->visa_type }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Visa Status:</th>
                                <td>
                                    <span class="badge bg-{{ $foreigner->visa_status === 'Active' ? 'success' : ($foreigner->visa_status === 'Expired' ? 'danger' : 'warning') }}">
                                        {{ $foreigner->visa_status }}
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
                                <th>Tanggal Kedaluwarsa Visa:</th>
                                <td>
                                    @if($foreigner->visa_expiry_date)
                                        {{ \App\Helpers\DateHelper::formatIndonesian($foreigner->visa_expiry_date, 'd F Y') }}
                                        @if($foreigner->visa_expiry_date->isPast())
                                            <span class="badge bg-danger ms-1">Kedaluwarsa</span>
                                        @elseif(floor($foreigner->visa_expiry_date->diffInDays()) < 30)
                                            <span class="badge bg-warning ms-1">{{ \App\Helpers\DateHelper::daysRemainingIndonesian($foreigner->visa_expiry_date) }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Tidak ditentukan</span>
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
                        <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-camera me-1"></i>
                            Tambah Foto
                        </a>
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
                    <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Information
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
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

<!-- Delete Confirmation Modal -->
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($foreigner->latitude && $foreigner->longitude)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([{{ $foreigner->latitude }}, {{ $foreigner->longitude }}], 13);
        
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

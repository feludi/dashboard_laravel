@extends('layouts.app')

@section('title', 'Foreign Nationals Data - Foreign Nationals Mapping System')
@section('page-title', 'Foreign Nationals Management')

@section('content')
<!-- Action Buttons -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Data Management
                    </h6>
                    <div class="btn-group" role="group">
                        <a href="{{ route('foreigners.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Add New Record
                        </a>
                        <a href="{{ route('imports.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-import me-2"></i>Import Excel
                        </a>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>Export Data
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" onclick="exportData('csv')">
                                    <i class="fas fa-file-csv me-2"></i>Export as CSV
                                </button></li>
                                <li><button class="dropdown-item" onclick="exportData('excel')">
                                    <i class="fas fa-file-excel me-2"></i>Export as Excel
                                </button></li>
                                <li><button class="dropdown-item" onclick="exportData('json')">
                                    <i class="fas fa-file-code me-2"></i>Export as JSON
                                </button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Compact Filter -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>Filter & Search
                </h6>
            </div>
            <div class="card-body p-3">
                <form method="GET" action="{{ route('foreigners.index') }}">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Name, passport, email...">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="nationality" name="nationality">
                                <option value="">All Countries</option>
                                @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality }}" {{ request('nationality') == $nationality ? 'selected' : '' }}>
                                        {{ $nationality }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="expiring_soon" {{ request('status') == 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                <option value="departed" {{ request('status') == 'departed' ? 'selected' : '' }}>Departed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="region" name="region">
                                <option value="">All Regions</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Results -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-2">
        <h6 class="card-title mb-0">
            <i class="fas fa-users me-2"></i>
            Foreign Nationals List <span class="badge bg-primary">{{ $foreigners->total() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th style="width: 200px;">Name</th>
                        <th style="width: 120px;">Country</th>
                        <th style="width: 100px;">Passport</th>
                        <th style="width: 80px;">Permit</th>
                        <th style="width: 120px;">Location</th>
                        <th style="width: 80px;">Status</th>
                        <th style="width: 100px;">Expires</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($foreigners as $foreigner)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($foreigner->photo)
                                    <img src="{{ asset('uploads/photos/' . $foreigner->photo) }}" 
                                         class="rounded-circle me-2" 
                                         alt="Photo"
                                         style="width: 32px; height: 32px; object-fit: cover;">
                                @else
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                         style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold text-truncate" style="max-width: 140px;">{{ $foreigner->full_name }}</div>
                                    <small class="text-muted">
                                        {{ ucfirst($foreigner->gender) }}
                                        @if($foreigner->date_of_birth)
                                            • {{ \App\Helpers\DateHelper::calculateAge($foreigner->date_of_birth) }} years old
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span style="font-size: 16px; margin-right: 6px;">{{ \App\Helpers\CountryHelper::getFlagEmoji($foreigner->nationality) }}</span>
                                <small>{{ $foreigner->nationality }}</small>
                            </div>
                        </td>
                        <td>
                            <code class="text-muted" style="font-size: 11px;">{{ $foreigner->passport_number }}</code>
                        </td>
                        <td>
                            <span class="badge bg-primary" style="font-size: 10px;">{{ $foreigner->residence_permit_type ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div style="font-size: 13px;">{{ $foreigner->city }}</div>
                            <small class="text-muted">{{ $foreigner->state_province }}</small>
                        </td>
                        <td>
                            @php
                                $statusColor = match($foreigner->status) {
                                    'active' => 'success',
                                    'expiring_soon' => 'warning',
                                    'expired' => 'danger',
                                    'departed' => 'danger',
                                    'pending' => 'primary',
                                    'cancelled' => 'secondary',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}" style="font-size: 10px;">
                                @if($foreigner->status === 'expiring_soon')
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                @elseif($foreigner->status === 'expired')
                                    <i class="fas fa-times-circle me-1"></i>
                                @elseif($foreigner->status === 'active')
                                    <i class="fas fa-check-circle me-1"></i>
                                @endif
                                {{ $foreigner->status === 'expiring_soon' ? 'Expiring Soon' : ucfirst($foreigner->status) }}
                            </span>
                        </td>
                        <td>
                            @if($foreigner->residence_permit_expiry_date)
                                <div style="font-size: 12px;">{{ \App\Helpers\DateHelper::formatIndonesian($foreigner->residence_permit_expiry_date, 'd M Y') }}</div>
                                @if($foreigner->residence_permit_expiry_date->isPast())
                                    <small class="text-danger" style="font-size: 10px;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Expired
                                    </small>
                                @elseif($foreigner->residence_permit_expiry_date->diffInDays() <= 30)
                                    <small class="text-warning" style="font-size: 10px;">
                                        <i class="fas fa-clock me-1"></i>{{ \App\Helpers\DateHelper::daysRemainingIndonesian($foreigner->residence_permit_expiry_date) }}
                                    </small>
                                @endif
                            @else
                                <div style="font-size: 12px;">
                                    <span class="badge bg-success text-white" style="font-size: 10px;">
                                        <i class="fas fa-infinity me-1"></i>Permanent
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('foreigners.show', $foreigner) }}" class="btn btn-outline-primary btn-sm" title="View">
                                    <i class="fas fa-eye" style="font-size: 11px;"></i>
                                </a>
                                <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit" style="font-size: 11px;"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" 
                                        onclick="deleteRecord({{ $foreigner->id }}, '{{ $foreigner->full_name }}')">
                                    <i class="fas fa-trash" style="font-size: 11px;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-users fa-2x mb-2 text-secondary"></i>
                                <p class="mb-2">No foreign nationals found matching your criteria.</p>
                                <a href="{{ route('foreigners.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Add Record
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($foreigners->hasPages())
    <div class="card-footer">
        {{ $foreigners->links() }}
    </div>
    @endif
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.nationality-flag {
    width: 24px;
    height: 16px;
    border-radius: 2px;
    border: 1px solid #ddd;
    object-fit: cover;
}

.flag-emoji {
    font-size: 16px;
    margin-right: 8px;
}
</style>
@endpush

@push('scripts')
<script>
function deleteRecord(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = `/foreigners/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function exportData(format) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', format);
    window.location.href = '{{ route('foreigners.index') }}?' + params.toString();
}
</script>
@endpush

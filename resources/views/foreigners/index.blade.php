@extends('layouts.app')

@section('title', 'Data WNA - Sistem Pemetaan WNA')
@section('page-title', 'Manajemen Data WNA')

@section('page-actions')
<a href="{{ route('foreigners.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Tambah Data WNA Baru
</a>
@endsection

@section('content')
<!-- Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('foreigners.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama, paspor, email...">
                        </div>
                        <div class="col-md-2">
                            <label for="nationality" class="form-label">Kewarganegaraan</label>
                            <select class="form-select" id="nationality" name="nationality">
                                <option value="">Semua</option>
                                @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality }}" {{ request('nationality') == $nationality ? 'selected' : '' }}>
                                        {{ $nationality }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                                <option value="departed" {{ request('status') == 'departed' ? 'selected' : '' }}>Sudah Berangkat</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="region" class="form-label">Wilayah</label>
                            <select class="form-select" id="region" name="region">
                                <option value="">Semua</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('foreigners.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Hapus
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-users me-2"></i>
            Daftar WNA ({{ $foreigners->total() }} total)
        </h6>
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary" onclick="exportData('csv')">
                <i class="fas fa-file-csv me-1"></i>CSV
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="exportData('excel')">
                <i class="fas fa-file-excel me-1"></i>Excel
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Kewarganegaraan</th>
                        <th>Paspor</th>
                        <th>Jenis Visa</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Kedaluwarsa Visa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($foreigners as $foreigner)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($foreigner->photo)
                                    <img src="{{ asset('uploads/photos/' . $foreigner->photo) }}" 
                                         class="rounded-circle me-3" 
                                         alt="Photo of {{ $foreigner->full_name }}"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold">{{ $foreigner->full_name }}</div>
                                    <small class="text-muted">{{ ucfirst($foreigner->gender) }} • {{ \App\Helpers\DateHelper::formatIndonesian($foreigner->date_of_birth, 'd F Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="d-flex align-items-center">
                                <img src="{{ \App\Helpers\CountryHelper::getFlagUrl($foreigner->nationality, '24') }}" 
                                     alt="{{ $foreigner->nationality }} flag" 
                                     class="nationality-flag me-2"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                <span class="flag-emoji" style="display:none;">{{ \App\Helpers\CountryHelper::getFlagEmoji($foreigner->nationality) }}</span>
                                {{ $foreigner->nationality }}
                            </span>
                        </td>
                        <td>
                            <code>{{ $foreigner->passport_number }}</code>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $foreigner->visa_type }}</span>
                        </td>
                        <td>
                            <div>{{ $foreigner->city }}</div>
                            <small class="text-muted">{{ $foreigner->state_province }}</small>
                        </td>
                        <td>
                            @php
                                $statusColor = match($foreigner->status) {
                                    'active' => 'success',
                                    'expired' => 'warning',
                                    'departed' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}">{{ ucfirst($foreigner->status) }}</span>
                        </td>
                        <td>
                            <div>{{ \App\Helpers\DateHelper::formatIndonesian($foreigner->visa_expiry_date, 'd F Y') }}</div>
                            @if($foreigner->is_visa_expired)
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Kedaluwarsa
                                </small>
                            @elseif($foreigner->visa_expiry_date->diffInDays() <= 30)
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i>{{ \App\Helpers\DateHelper::daysRemainingIndonesian($foreigner->visa_expiry_date) }}
                                </small>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('foreigners.show', $foreigner) }}" class="btn btn-outline-primary" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('foreigners.edit', $foreigner) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" title="Hapus" 
                                        onclick="deleteRecord({{ $foreigner->id }}, '{{ $foreigner->full_name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p>Tidak ada WNA yang ditemukan sesuai kriteria Anda.</p>
                                <a href="{{ route('foreigners.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Data WNA Pertama
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
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong id="deleteName"></strong>?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
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

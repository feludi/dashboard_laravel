@extends('layouts.app')

@section('title', 'Dashboard - SIMWNA Kantor Imigrasi Kelas I TPI Cirebon')
@section('page-title', 'Ikhtisar Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Kartu Statistik -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total WNA</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_foreigners']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Status Aktif</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['active_foreigners']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Visa Kedaluwarsa</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['expired_visas']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Visa Akan Kedaluwarsa</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['expiring_soon'] ?? 0) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Map View -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-map me-2"></i>
                    Distribusi Geografis
                </h6>
            </div>
            <div class="card-body">
                <div id="dashboard-map" class="map-container"></div>
            </div>
        </div>
    </div>

    <!-- Recent Entries -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i>
                    Kedatangan Terbaru
                </h6>
            </div>
            <div class="card-body">
                @forelse($stats['recent_entries'] ?? [] as $entry)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-gray-500">{{ \App\Helpers\DateHelper::formatIndonesian($entry['entry_date'], 'd F Y') }}</div>
                            <div class="font-weight-bold">{{ $entry['first_name'] }} {{ $entry['last_name'] }}</div>
                            <div class="small">
                                <img src="{{ \App\Helpers\CountryHelper::getFlagUrl($entry['nationality']) }}" 
                                     class="nationality-flag me-1" 
                                     alt="{{ $entry['nationality'] }}"
                                     style="width: 16px; height: 12px; object-fit: cover; vertical-align: middle;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                <span style="display: none; font-size: 12px;">{{ \App\Helpers\CountryHelper::getFlagEmoji($entry['nationality']) }}</span>
                                {{ $entry['nationality'] }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada kedatangan terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Nationality Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-flag me-2"></i>
                    Kewarganegaraan Teratas
                </h6>
            </div>
            <div class="card-body">
                <canvas id="nationalityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Regional Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-map me-2"></i>
                    Distribusi Wilayah
                </h6>
            </div>
            <div class="card-body">
                <canvas id="regionalChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Visa Types -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-passport me-2"></i>
                    Distribusi Jenis Visa
                </h6>
            </div>
            <div class="card-body">
                <canvas id="visaTypeChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    const map = L.map('dashboard-map').setView([0, 0], 2);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add markers for foreigners
    const foreigners = @json($foreignersForMap);
    foreigners.forEach(function(foreigner) {
        if (foreigner.latitude && foreigner.longitude) {
            L.marker([foreigner.latitude, foreigner.longitude])
                .bindPopup(`
                    <strong>${foreigner.first_name} ${foreigner.last_name}</strong><br>
                    Nationality: ${foreigner.nationality}<br>
                    City: ${foreigner.city}
                `)
                .addTo(map);
        }
    });

    // Nationality Chart
    const nationalityData = @json($stats['by_nationality'] ?? []);
    new Chart(document.getElementById('nationalityChart'), {
        type: 'doughnut',
        data: {
            labels: nationalityData.map(item => item.nationality),
            datasets: [{
                data: nationalityData.map(item => item.count),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
                    '#4BC0C0', '#FF6384'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Regional Chart
    const regionalData = @json($stats['by_region'] ?? []);
    new Chart(document.getElementById('regionalChart'), {
        type: 'bar',
        data: {
            labels: regionalData.map(item => item.city),
            datasets: [{
                label: 'Number of Foreigners',
                data: regionalData.map(item => item.count),
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Visa Type Chart
    const visaData = @json($visaTypeStats);
    new Chart(document.getElementById('visaTypeChart'), {
        type: 'horizontalBar',
        data: {
            labels: visaData.map(item => item.visa_type),
            datasets: [{
                label: 'Number of Visas',
                data: visaData.map(item => item.count),
                backgroundColor: '#4BC0C0'
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush

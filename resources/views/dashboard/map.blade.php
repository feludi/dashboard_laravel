@extends('layouts.app')

@section('title', 'Peta Interaktif - SIMWNA Kantor Imigrasi Kelas I TPI Cirebon')
@section('page-title', 'Peta Interaktif')

@section('page-actions')
<div class="btn-group" role="group">
    <button type="button" class="btn btn-outline-primary" id="toggleClusters">
        <i class="fas fa-layer-group me-2"></i>Tampilkan Cluster
    </button>
    <button type="button" class="btn btn-outline-primary" id="toggleRegions">
        <i class="fas fa-map me-2"></i>Tampilkan Wilayah
    </button>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <!-- Map Controls -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nationalityFilter" class="form-label">Filter berdasarkan Kewarganegaraan</label>
                        <select class="form-select" id="nationalityFilter">
                            <option value="">Semua Kewarganegaraan</option>
                            @foreach($foreigners->pluck('nationality')->unique()->sort() as $nationality)
                                <option value="{{ $nationality }}">{{ $nationality }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Filter berdasarkan Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="expired">Kedaluwarsa</option>
                            <option value="departed">Sudah Berangkat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="visaFilter" class="form-label">Filter berdasarkan Jenis Visa</label>
                        <select class="form-select" id="visaFilter">
                            <option value="">Semua Jenis Visa</option>
                            @foreach($foreigners->pluck('visa_type')->unique()->sort() as $visaType)
                                <option value="{{ $visaType }}">{{ $visaType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-primary" id="applyFilters">
                            <i class="fas fa-filter me-2"></i>Terapkan Filter
                        </button>
                        <button type="button" class="btn btn-outline-secondary ms-2" id="clearFilters">
                            <i class="fas fa-times me-2"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Map -->
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-globe me-2"></i>
                    Peta Distribusi Geografis
                </h6>
                <div class="map-stats">
                    <span class="badge bg-primary" id="visibleMarkers">{{ $foreigners->count() }} penanda</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="main-map" style="height: 600px;"></div>
            </div>
        </div>
    </div>

    <!-- Map Legend & Info -->
    <div class="col-lg-3">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    Legenda Peta
                </h6>
            </div>
            <div class="card-body">
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-success me-2"></i>
                    <small>Status Aktif</small>
                </div>
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-warning me-2"></i>
                    <small>Visa Kedaluwarsa</small>
                </div>
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-danger me-2"></i>
                    <small>Sudah Berangkat</small>
                </div>
                <div class="legend-item mb-2">
                    <i class="fas fa-square text-primary me-2"></i>
                    <small>Batas Wilayah</small>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Total WNA:</span>
                        <strong>{{ $foreigners->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Aktif:</span>
                        <strong class="text-success">{{ $foreigners->where('status', 'active')->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Visa Kedaluwarsa:</span>
                        <strong class="text-warning">{{ $foreigners->where('visa_expiry_date', '<', now())->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Kewarganegaraan:</span>
                        <strong>{{ $foreigners->pluck('nationality')->unique()->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-mouse-pointer me-2"></i>
                    Selected Info
                </h6>
            </div>
            <div class="card-body">
                <div id="selected-info">
                    <p class="text-muted mb-0">Click on a marker to view details</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Flag emoji helper function
    function getFlagEmoji(nationality) {
        const flagMap = {
            'Indonesia': '🇮🇩', 'United States': '🇺🇸', 'United Kingdom': '🇬🇧', 'Canada': '🇨🇦',
            'Australia': '🇦🇺', 'Germany': '🇩🇪', 'France': '🇫🇷', 'Japan': '🇯🇵', 'China': '🇨🇳',
            'India': '🇮🇳', 'Netherlands': '🇳🇱', 'Singapore': '🇸🇬', 'Malaysia': '🇲🇾', 'Thailand': '🇹🇭',
            'South Korea': '🇰🇷', 'Italy': '🇮🇹', 'Spain': '🇪🇸', 'Brazil': '🇧🇷', 'Mexico': '🇲🇽',
            'Philippines': '🇵🇭', 'Vietnam': '🇻🇳', 'Russia': '🇷🇺', 'Turkey': '🇹🇷', 'Saudi Arabia': '🇸🇦'
        };
        return flagMap[nationality] || '🇺🇳';
    }

    // Initialize map
    const map = L.map('main-map').setView([-6.7320, 108.5520], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Data
    const foreignersData = @json($foreigners);
    const regionsData = @json($regions);
    
    let markers = [];
    let regionLayers = [];
    let clustersEnabled = true;
    let regionsVisible = true;

    // Create marker group
    const markerGroup = L.layerGroup().addTo(map);
    
    // Function to get marker color based on status
    function getMarkerColor(foreigner) {
        if (foreigner.status === 'departed') return 'red';
        if (new Date(foreigner.visa_expiry_date) < new Date()) return 'orange';
        return 'green';
    }

    // Function to create marker
    function createMarker(foreigner) {
        if (!foreigner.latitude || !foreigner.longitude) return null;
        
        const color = getMarkerColor(foreigner);
        const marker = L.circleMarker([foreigner.latitude, foreigner.longitude], {
            color: color,
            fillColor: color,
            fillOpacity: 0.7,
            radius: 8
        });

        const popupContent = `
            <div class="marker-popup">
                <h6 class="mb-2">${foreigner.first_name} ${foreigner.last_name}</h6>
                <p class="mb-1">
                    <strong>Nationality:</strong> 
                    <span style="font-size: 14px; margin-right: 5px;">${getFlagEmoji(foreigner.nationality)}</span>
                    ${foreigner.nationality}
                </p>
                <p class="mb-1"><strong>Visa Type:</strong> ${foreigner.visa_type}</p>
                <p class="mb-1"><strong>Status:</strong> 
                    <span class="badge bg-${color === 'green' ? 'success' : color === 'orange' ? 'warning' : 'danger'}">
                        ${foreigner.status}
                    </span>
                </p>
                <p class="mb-1"><strong>Location:</strong> ${foreigner.city}, ${foreigner.state_province}</p>
                <p class="mb-1"><strong>Entry Date:</strong> ${new Date(foreigner.entry_date).toLocaleDateString()}</p>
                <p class="mb-0"><strong>Visa Expiry:</strong> ${new Date(foreigner.visa_expiry_date).toLocaleDateString()}</p>
                <div class="mt-2">
                    <a href="/foreigners/${foreigner.id}" class="btn btn-sm btn-primary">View Details</a>
                </div>
            </div>
        `;

        marker.bindPopup(popupContent);
        
        // Add click event for selected info panel
        marker.on('click', function() {
            document.getElementById('selected-info').innerHTML = `
                <h6>${foreigner.first_name} ${foreigner.last_name}</h6>
                <p class="mb-1">
                    <strong>Nationality:</strong> 
                    <span style="font-size: 14px; margin-right: 5px;">${getFlagEmoji(foreigner.nationality)}</span>
                    ${foreigner.nationality}
                </p>
                <p class="mb-1"><strong>City:</strong> ${foreigner.city}</p>
                <p class="mb-1"><strong>Status:</strong> ${foreigner.status}</p>
                <p class="mb-0"><strong>Passport:</strong> ${foreigner.passport_number}</p>
            `;
        });

        return marker;
    }

    // Add all markers
    function addMarkers(data = foreignersData) {
        markerGroup.clearLayers();
        markers = [];
        
        data.forEach(function(foreigner) {
            const marker = createMarker(foreigner);
            if (marker) {
                markers.push(marker);
                markerGroup.addLayer(marker);
            }
        });
        
        updateMarkerCount(markers.length);
    }

    // Add regions
    function addRegions() {
        regionsData.forEach(function(region) {
            if (region.latitude && region.longitude) {
                const regionMarker = L.marker([region.latitude, region.longitude], {
                    icon: L.divIcon({
                        html: `<div class="region-marker"><i class="fas fa-map-marker-alt"></i></div>`,
                        className: 'custom-div-icon',
                        iconSize: [30, 30],
                        iconAnchor: [15, 30]
                    })
                });

                regionMarker.bindPopup(`
                    <div>
                        <h6>${region.name}</h6>
                        <p class="mb-1"><strong>Code:</strong> ${region.code}</p>
                        <p class="mb-1"><strong>Country:</strong> ${region.country}</p>
                        ${region.population ? `<p class="mb-0"><strong>Population:</strong> ${region.population.toLocaleString()}</p>` : ''}
                    </div>
                `);

                regionLayers.push(regionMarker);
                if (regionsVisible) {
                    regionMarker.addTo(map);
                }
            }
        });
    }

    // Filter functions
    function applyFilters() {
        const nationality = document.getElementById('nationalityFilter').value;
        const status = document.getElementById('statusFilter').value;
        const visaType = document.getElementById('visaFilter').value;

        let filteredData = foreignersData;

        if (nationality) {
            filteredData = filteredData.filter(f => f.nationality === nationality);
        }
        if (status) {
            filteredData = filteredData.filter(f => f.status === status);
        }
        if (visaType) {
            filteredData = filteredData.filter(f => f.visa_type === visaType);
        }

        addMarkers(filteredData);
    }

    function clearFilters() {
        document.getElementById('nationalityFilter').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('visaFilter').value = '';
        addMarkers();
    }

    function updateMarkerCount(count) {
        document.getElementById('visibleMarkers').textContent = `${count} markers`;
    }

    // Event listeners
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('clearFilters').addEventListener('click', clearFilters);

    document.getElementById('toggleRegions').addEventListener('click', function() {
        regionsVisible = !regionsVisible;
        regionLayers.forEach(layer => {
            if (regionsVisible) {
                layer.addTo(map);
            } else {
                map.removeLayer(layer);
            }
        });
        this.classList.toggle('active');
    });

    // Initialize
    addMarkers();
    addRegions();
});
</script>

<style>
.marker-popup {
    min-width: 250px;
}

.region-marker {
    background: #007bff;
    color: white;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.custom-div-icon {
    background: transparent;
    border: none;
}

.legend-item {
    display: flex;
    align-items: center;
}

.stat-row {
    padding: 0.25rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.stat-row:last-child {
    border-bottom: none;
}
</style>
@endpush

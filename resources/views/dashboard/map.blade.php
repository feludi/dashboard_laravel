@extends('layouts.app')

@section('title', 'Interactive Map - ImmiTrace Immigration Office Class I TPI Cirebon')
@section('page-title', 'Interactive Map')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<style>
    /* Ensure map container has proper dimensions */
    #main-map {
        width: 100% !important;
        height: 500px !important;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    /* Ensure proper layout within main content area */
    .map-container {
        height: 500px;
        width: 100%;
        position: relative;
    }
    
    /* Fullscreen styles */
    .map-fullscreen {
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }
    
    .map-fullscreen * {
        visibility: hidden;
    }
    
    .map-fullscreen .fullscreen-card,
    .map-fullscreen .fullscreen-card *,
    .map-fullscreen .page-actions,
    .map-fullscreen .page-actions * {
        visibility: visible !important;
    }
    
    .fullscreen-card {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 9999 !important;
        border: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
        background: #000 !important;
    }
    
    .fullscreen-card .card-header {
        display: none !important;
    }
    
    .fullscreen-card .card-body {
        padding: 0 !important;
        height: 100vh !important;
    }
    
    .fullscreen-card #main-map {
        width: 100vw !important;
        height: 100vh !important;
    }
    
    .map-fullscreen .page-actions {
        position: fixed !important;
        top: 20px !important;
        right: 20px !important;
        z-index: 10000 !important;
        background: rgba(255, 255, 255, 0.95) !important;
        padding: 10px !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
    }
    
    /* Debug: Make sure content is within proper bounds */
    main.col-lg-10 {
        background-color: #f8f9fa;
    }
</style>
@endpush

@section('page-actions')
<div class="btn-group page-actions" role="group">
    <button type="button" class="btn btn-outline-primary" id="toggleClusters">
        <i class="fas fa-layer-group me-2"></i>Show Clusters
    </button>
    <button type="button" class="btn btn-outline-primary" id="toggleRegions">
        <i class="fas fa-map me-2"></i>Hide Regions
    </button>
    <button type="button" class="btn btn-outline-info" id="fullscreenMap">
        <i class="fas fa-expand me-2"></i>Fullscreen
    </button>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <!-- Map Filters & Search -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-filter me-2"></i>
                    Search & Filter Options
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nationalityFilter" class="form-label">Filter by Nationality</label>
                        <select class="form-select" id="nationalityFilter">
                            <option value="">All Nationalities</option>
                            @foreach($foreigners->pluck('nationality')->unique()->sort() as $nationality)
                                <option value="{{ $nationality }}">{{ $nationality }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Filter by Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                            <option value="departed">Departed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="residencePermitFilter" class="form-label">Filter by Residence Permit Type</label>
                        <select class="form-select" id="residencePermitFilter">
                            <option value="">All Residence Permit Types</option>
                            @foreach($foreigners->pluck('residence_permit_type')->unique()->sort() as $permitType)
                                <option value="{{ $permitType }}">{{ $permitType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="cityFilter" class="form-label">Filter by City</label>
                        <select class="form-select" id="cityFilter">
                            <option value="">All Cities</option>
                            @foreach($foreigners->pluck('city')->unique()->sort() as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="nameSearch" class="form-label">Search by Name</label>
                        <input type="text" class="form-control" id="nameSearch" placeholder="Enter first or last name...">
                    </div>
                    <div class="col-md-2">
                        <label for="expiryFilter" class="form-label">Residence Permit Status</label>
                        <select class="form-select" id="expiryFilter">
                            <option value="">All</option>
                            <option value="expired">Expired</option>
                            <option value="expiring">Expiring Soon</option>
                            <option value="valid">Valid</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="distanceFilter" class="form-label">Distance (km)</label>
                        <select class="form-select" id="distanceFilter">
                            <option value="">All</option>
                            <option value="5">Within 5km</option>
                            <option value="10">Within 10km</option>
                            <option value="25">Within 25km</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary me-2" id="applyFilters">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        <button type="button" class="btn btn-outline-secondary me-2" id="clearFilters">
                            <i class="fas fa-times me-2"></i>Clear
                        </button>
                        <button type="button" class="btn btn-outline-info" id="showAllMarkers">
                            <i class="fas fa-eye me-2"></i>Show All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Map Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-globe me-2"></i>
                    Geographic Distribution Map
                </h6>
                <div class="map-stats">
                    <span class="badge bg-primary" id="visibleMarkers">{{ $foreigners->count() }} markers</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="main-map" class="map-container"></div>
            </div>
        </div>
    </div>
</div>

<!-- Map Information Row -->
<div class="row">
    <!-- Map Legend -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    Map Legend
                </h6>
            </div>
            <div class="card-body">
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-success me-2"></i>
                    <small>Active Status</small>
                </div>
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-warning me-2"></i>
                    <small>Expiring Soon</small>
                </div>
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-danger me-2"></i>
                    <small>Expired</small>
                </div>
                <div class="legend-item mb-2">
                    <i class="fas fa-circle text-secondary me-2"></i>
                    <small>Departed</small>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>
                    Quick Statistics
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
                        <span>Active:</span>
                        <strong class="text-success">{{ $foreigners->where('status', 'active')->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Expired Visas:</span>
                        <strong class="text-danger">{{ $foreigners->where('visa_expiry_date', '<', now())->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Expiring Soon:</span>
                        <strong class="text-warning">{{ $foreigners->where('visa_expiry_date', '>', now())->where('visa_expiry_date', '<', now()->addDays(30))->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Countries:</span>
                        <strong>{{ $foreigners->pluck('nationality')->unique()->count() }}</strong>
                    </div>
                </div>
                <div class="stat-row mb-2">
                    <div class="d-flex justify-content-between">
                        <span>Cities:</span>
                        <strong>{{ $foreigners->pluck('city')->unique()->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Statistics -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>
                    Nationality Distribution
                </h6>
            </div>
            <div class="card-body">
                @php
                    $topNationalities = $foreigners->groupBy('nationality')->map->count()->sortDesc()->take(5);
                @endphp
                @foreach($topNationalities as $nationality => $count)
                    <div class="stat-row mb-2">
                        <div class="d-flex justify-content-between">
                            <span>{{ \App\Helpers\CountryHelper::getFlagEmoji($nationality) }} {{ $nationality }}:</span>
                            <strong>{{ $count }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i>
                    Recent Entries
                </h6>
            </div>
            <div class="card-body">
                @php
                    $recentEntries = $foreigners->whereNotNull('entry_date')->sortByDesc('entry_date')->take(5);
                @endphp
                @foreach($recentEntries as $recent)
                    <div class="stat-row mb-2">
                        <div class="d-flex flex-column">
                            <small class="fw-bold">{{ $recent->first_name }} {{ $recent->last_name }}</small>
                            <small class="text-muted">{{ \App\Helpers\CountryHelper::getFlagEmoji($recent->nationality) }} {{ $recent->nationality }} - {{ \Carbon\Carbon::parse($recent->entry_date)->format('M d, Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Selected Info -->
    <div class="col-lg-4">
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
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
// Suppress Mozilla-specific deprecation warnings
if (typeof console !== 'undefined' && console.warn) {
    const originalWarn = console.warn;
    console.warn = function(...args) {
        const message = args.join(' ');
        if (message.includes('mozPressure') || message.includes('mozInputSource')) {
            return; // Suppress these specific warnings
        }
        originalWarn.apply(console, args);
    };
}

document.addEventListener('DOMContentLoaded', function() {
    try {
        console.log('🗺️ Map starting up...');
    
    // Fix for Leaflet default icons - use proper CDN URLs
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png'
    });
    
    // Make sure the map div exists
    const mapDiv = document.getElementById('main-map');
    if (!mapDiv) {
        console.error('Map container not found!');
        return;
    }
    
    console.log('🔧 Starting map initialization...');
    
    // Get country flags from PHP helper with error handling
    let countryFlags = {};
    try {
        countryFlags = {
            @foreach($foreigners->pluck('nationality')->unique() as $nationality)
                '{{ $nationality }}': '{{ \App\Helpers\CountryHelper::getFlagEmoji($nationality) }}',
            @endforeach
        };
    } catch (flagError) {
        console.warn('⚠️ Failed to load country flags:', flagError);
        countryFlags = {};
    }
        
        console.log('✅ Loaded flags for', Object.keys(countryFlags).length, 'countries');
        
        // Helper to get flag emoji
        function getFlag(country) {
            if (!country || !countryFlags) return '🏳️';
            return countryFlags[country] || '🏳️';
        }

        console.log('Setting up map...');
        // Create the map centered on Cirebon
        const myMap = L.map('main-map', {
            center: [-6.7320, 108.5520], // Cirebon coords
            zoom: 11,
            zoomControl: true,
            scrollWheelZoom: true
        });
        
        console.log('Map created successfully');
        
        // Add OpenStreetMap tiles
        const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        });
        
        tiles.on('tileerror', function(err) {
            console.warn('Tile loading issue:', err);
        });
        
        tiles.addTo(myMap);
        console.log('Map tiles loaded');
        

        
        // Force map to resize to fit container properly
        setTimeout(() => {
            myMap.invalidateSize();
            console.log('Map resized to fit container');
        }, 500);

        // Get the data from Laravel
        const allForeigners = @json($foreigners);
        console.log('Got data for', allForeigners.length, 'people');
        
        const foreignersData = Array.isArray(allForeigners) ? allForeigners : [];
        console.log('Processing', foreignersData.length, 'records');
        
        // Log each foreigner's coordinates
        let validCoordinates = 0;
        foreignersData.forEach((f, i) => {
            if (f.latitude && f.longitude) {
                validCoordinates++;
                console.log(`✓ Foreigner ${i + 1}: ${f.first_name} ${f.last_name} at lat:${f.latitude}, lng:${f.longitude}`);
            } else {
                console.log(`⚠️ Foreigner ${i + 1}: ${f.first_name} ${f.last_name} - Missing coordinates`);
            }
        });
        
        console.log(`📍 Valid coordinates: ${validCoordinates}/${foreignersData.length}`);
        
        const regionsData = @json($regions);
        console.log('🗺️ Regions data:', regionsData);
        console.log('📍 Number of regions:', regionsData ? regionsData.length : 0);
        
        let markers = [];
        let regionLayers = [];
        let clustersEnabled = false;
        let regionsVisible = true;  // Show regions by default

        // Create layer groups
        const markerGroup = L.layerGroup().addTo(myMap);
        const clusterGroup = L.markerClusterGroup({
            chunkedLoading: true,
            chunkProgress: function(processed, total, elapsed) {
                console.log(`🔄 Processing markers: ${processed}/${total}`);
            }
        });
        
        console.log('📊 Layer groups created');
        
        // Function to get marker color based on status
        function getMarkerColor(foreigner) {
            try {
                if (foreigner.status === 'departed') return '#6c757d'; // gray
                
                if (foreigner.visa_expiry_date) {
                    const expiryDate = new Date(foreigner.visa_expiry_date);
                    const today = new Date();
                    const daysUntilExpiry = Math.ceil((expiryDate - today) / (1000 * 60 * 60 * 24));
                    
                    if (daysUntilExpiry < 0) return '#dc3545'; // red - expired
                    if (daysUntilExpiry <= 30) return '#fd7e14'; // orange - expiring soon
                }
                
                return '#28a745'; // green - active
            } catch (error) {
                console.warn('⚠️ Error determining marker color:', error);
                return '#007bff'; // default blue
            }
        }

        // Function to create marker with improved error handling
        function createMarker(foreigner) {
            try {
                if (!foreigner.latitude || !foreigner.longitude) {
                    console.warn('⚠️ Missing coordinates for:', foreigner.first_name, foreigner.last_name);
                    return null;
                }
                
                const lat = parseFloat(foreigner.latitude);
                const lng = parseFloat(foreigner.longitude);
                
                if (isNaN(lat) || isNaN(lng)) {
                    console.warn('⚠️ Invalid coordinates for:', foreigner.first_name, foreigner.last_name, 'lat:', foreigner.latitude, 'lng:', foreigner.longitude);
                    return null;
                }
                
                const color = getMarkerColor(foreigner);
                const marker = L.circleMarker([lat, lng], {
                    color: '#ffffff',
                    weight: 2,
                    fillColor: color,
                    fillOpacity: 0.8,
                    radius: 8
                });

                // Format dates safely
                const formatDate = (dateStr) => {
                    if (!dateStr) return 'Not specified';
                    try {
                        return new Date(dateStr).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    } catch (e) {
                        return 'Invalid date';
                    }
                };

                const popupContent = `
                    <div class="marker-popup">
                        <div class="d-flex align-items-center mb-2">
                            <span class="flag-emoji">${getFlag(foreigner.nationality)}</span>
                            <h6 class="mb-0">${foreigner.first_name || ''} ${foreigner.last_name || ''}</h6>
                        </div>
                        <div class="popup-details">
                            <div class="row">
                                <div class="col-6"><strong>Nationality:</strong></div>
                                <div class="col-6">${foreigner.nationality || 'N/A'}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Passport:</strong></div>
                                <div class="col-6">${foreigner.passport_number || 'N/A'}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Residence Permit Type:</strong></div>
                                <div class="col-6">${foreigner.residence_permit_type || 'N/A'}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Status:</strong></div>
                                <div class="col-6">
                                    <span class="badge status-badge" style="background-color: ${color};">
                                        ${(foreigner.status || 'N/A').toUpperCase()}
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Location:</strong></div>
                                <div class="col-6">${foreigner.city || 'N/A'}, ${foreigner.state_province || 'N/A'}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Entry Date:</strong></div>
                                <div class="col-6">${formatDate(foreigner.entry_date)}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Residence Permit Expiry:</strong></div>
                                <div class="col-6">${formatDate(foreigner.visa_expiry_date)}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><strong>Coordinates:</strong></div>
                                <div class="col-6">${lat.toFixed(4)}, ${lng.toFixed(4)}</div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="/foreigners/${foreigner.id}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);

                marker.on('click', function() {
                    console.log('📍 Marker clicked:', foreigner.first_name, foreigner.last_name);
                    updateSelectedInfo(foreigner);
                });

                return marker;
            } catch (error) {
                console.error('❌ Error creating marker for:', foreigner.first_name, foreigner.last_name, error);
                return null;
            }
        }

        // Function to update selected info panel
        function updateSelectedInfo(foreigner) {
            try {
                const selectedInfoElement = document.getElementById('selected-info');
                if (selectedInfoElement) {
                    selectedInfoElement.innerHTML = `
                        <div class="text-center mb-2">
                            <span class="flag-emoji-large">${getFlag(foreigner.nationality)}</span>
                        </div>
                        <h6 class="text-center mb-2">${foreigner.first_name || ''} ${foreigner.last_name || ''}</h6>
                        <div class="selected-details">
                            <p class="mb-1"><strong>Nationality:</strong> ${foreigner.nationality || 'N/A'}</p>
                            <p class="mb-1"><strong>City:</strong> ${foreigner.city || 'N/A'}</p>
                            <p class="mb-1"><strong>Status:</strong> 
                                <span class="badge status-badge-small" style="background-color: ${getMarkerColor(foreigner)};">
                                    ${(foreigner.status || 'N/A').toUpperCase()}
                                </span>
                            </p>
                            <p class="mb-0"><strong>Passport:</strong> ${foreigner.passport_number || 'N/A'}</p>
                        </div>
                        <div class="mt-2 text-center">
                            <a href="/foreigners/${foreigner.id}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Full Details
                            </a>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('❌ Error updating selected info:', error);
            }
        }

    // Add all markers
    function addMarkers(data = foreignersData) {
        // Clear existing markers
        markerGroup.clearLayers();
        clusterGroup.clearLayers();
        markers = [];
        
        // If no data with coordinates, add sample markers for testing
        if (!data || data.length === 0) {
            const sampleData = [
                {
                    id: 1,
                    first_name: 'John',
                    last_name: 'Doe',
                    nationality: 'American',
                    residence_permit_type: 'Tourist',
                    status: 'active',
                    city: 'Cirebon',
                    state_province: 'West Java',
                    latitude: -6.7063,
                    longitude: 108.5565,
                    entry_date: '2024-01-15',
                    visa_expiry_date: '2024-07-15'
                },
                {
                    id: 2,
                    first_name: 'Jane',
                    last_name: 'Smith',
                    nationality: 'Singaporean',
                    residence_permit_type: 'Business',
                    status: 'active',
                    city: 'Cirebon',
                    state_province: 'West Java',
                    latitude: -6.7320,
                    longitude: 108.5520,
                    entry_date: '2024-02-01',
                    visa_expiry_date: '2024-08-01'
                }
            ];
            data = sampleData;
        }
        
        data.forEach(function(foreigner) {
            const marker = createMarker(foreigner);
            if (marker) {
                markers.push(marker);
                if (clustersEnabled) {
                    clusterGroup.addLayer(marker);
                } else {
                    markerGroup.addLayer(marker);
                }
            }
        });
        
        // Add appropriate layer to map
        if (clustersEnabled && !myMap.hasLayer(clusterGroup)) {
            myMap.addLayer(clusterGroup);
        }
        
        updateMarkerCount(markers.length);
    }

    // Load REAL administrative boundary data from reliable sources
    async function loadGADMBoundaries() {
        console.log('🌍 Loading REAL administrative boundary data...');
        
        const regions = [
            { name: 'Kabupaten Cirebon', osm_id: 'relation/1810012', code: '3209', searchTerm: 'Cirebon+kabupaten+west+java+indonesia' },
            { name: 'Kota Cirebon', osm_id: 'relation/1810016', code: '3271', searchTerm: 'Cirebon+city+west+java+indonesia' },
            { name: 'Kuningan', osm_id: 'relation/1810013', code: '3208', searchTerm: 'Kuningan+kabupaten+west+java+indonesia' },
            { name: 'Majalengka', osm_id: 'relation/1810014', code: '3210', searchTerm: 'Majalengka+kabupaten+west+java+indonesia' },
            { name: 'Indramayu', osm_id: 'relation/1810015', code: '3212', searchTerm: 'Indramayu+kabupaten+west+java+indonesia' }
        ];
        
        // First, try to get real data
        let realDataLoaded = false;
        
        try {
            // Try Nominatim API first (most reliable)
            for (const region of regions) {
                try {
                    const nominatimUrl = `https://nominatim.openstreetmap.org/search?q=${region.searchTerm}&format=geojson&polygon_geojson=1&limit=1`;
                    console.log(`🔍 Trying Nominatim for ${region.name}: ${nominatimUrl}`);
                    
                    const response = await fetch(nominatimUrl, {
                        headers: { 'User-Agent': 'ImmiTrace-Dashboard/1.0' }
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        console.log(`📊 Nominatim response for ${region.name}:`, data);
                        
                        if (data.features && data.features.length > 0) {
                            const feature = data.features[0];
                            console.log(`🔍 Feature geometry type for ${region.name}:`, feature.geometry?.type);
                            
                            if (feature.geometry && (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon')) {
                                const layer = L.geoJSON(feature, {
                                    style: {
                                        color: region.name.includes('Kota') ? '#9b59b6' : '#e74c3c', // Purple for Kota, red for Kabupaten
                                        weight: 3,
                                        opacity: 0.8,
                                        fillColor: region.name.includes('Kota') ? '#9b59b6' : '#e74c3c',
                                        fillOpacity: 0.15
                                    }
                                });
                                
                                layer.bindPopup(`
                                    <div>
                                        <h6><i class="fas fa-map-marked-alt"></i> ${region.name}</h6>
                                        <p class="mb-1"><strong>Type:</strong> ${region.name.includes('Kota') ? 'Kota (City)' : 'Kabupaten (District)'}</p>
                                        <p class="mb-1"><strong>Code:</strong> ${region.code}</p>
                                        <p class="mb-0"><small class="text-success">✅ Real OSM Boundary Data</small></p>
                                    </div>
                                `);
                                
                                regionLayers.push(layer);
                                realDataLoaded = true;
                                console.log(`✅ Added real boundary for ${region.name} (${feature.geometry.type})`);
                            } else {
                                console.warn(`⚠️ No valid geometry for ${region.name}, geometry:`, feature.geometry?.type);
                            }
                        } else {
                            console.warn(`⚠️ No features found for ${region.name}`);
                        }
                    } else {
                        console.warn(`❌ HTTP ${response.status} for ${region.name}`);
                    }
                } catch (error) {
                    console.warn(`❌ Nominatim failed for ${region.name}:`, error);
                }
            }
        } catch (error) {
            console.error('Error fetching real boundary data:', error);
        }
        
        // Special handling for Kota Cirebon if not found
        if (!realDataLoaded || regionLayers.length < 5) {
            console.log('🔍 Trying alternative search for missing regions...');
            
            const alternativeSearches = [
                { name: 'Kota Cirebon', queries: ['Cirebon+city', 'Kota+Cirebon+Indonesia', 'Cirebon+municipality'] },
                { name: 'Kabupaten Cirebon', queries: ['Cirebon+regency', 'Kabupaten+Cirebon'] }
            ];
            
            for (const region of alternativeSearches) {
                for (const query of region.queries) {
                    try {
                        const altUrl = `https://nominatim.openstreetmap.org/search?q=${query}&format=geojson&polygon_geojson=1&limit=1&countrycodes=id`;
                        console.log(`🔄 Alternative search for ${region.name}: ${altUrl}`);
                        
                        const response = await fetch(altUrl, {
                            headers: { 'User-Agent': 'ImmiTrace-Dashboard/1.0' }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            if (data.features && data.features.length > 0) {
                                const feature = data.features[0];
                                if (feature.geometry && (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon')) {
                                    const layer = L.geoJSON(feature, {
                                        style: {
                                            color: region.name.includes('Kota') ? '#9b59b6' : '#e67e22', // Purple for Kota, orange for Kabupaten (alternative search)
                                            weight: 3,
                                            opacity: 0.8,
                                            fillColor: region.name.includes('Kota') ? '#9b59b6' : '#e67e22',
                                            fillOpacity: 0.15,
                                            dashArray: '5, 5'  // Dashed line for alternative search results
                                        }
                                    });
                                    
                                    layer.bindPopup(`
                                        <div>
                                            <h6><i class="fas fa-search"></i> ${region.name}</h6>
                                            <p class="mb-1"><strong>Type:</strong> ${region.name.includes('Kota') ? 'Kota (City)' : 'Kabupaten (District)'}</p>
                                            <p class="mb-0"><small class="text-warning">⚠️ Alternative Search Result</small></p>
                                        </div>
                                    `);
                                    
                                    regionLayers.push(layer);
                                    console.log(`✅ Added ${region.name} via alternative search`);
                                    break; // Found one, move to next region
                                }
                            }
                        }
                    } catch (error) {
                        console.warn(`Alternative search failed for ${region.name}:`, error);
                    }
                }
            }
        }
        
        // If no real data was loaded, create visible boundary approximations
        if (!realDataLoaded) {
            console.log('📍 Creating visible boundary lines as fallback...');
            
            // Create visible boundary shapes for each region
            const boundaryShapes = [
                {
                    name: 'Kabupaten Cirebon',
                    coords: [
                        [-6.65, 108.45], [-6.62, 108.55], [-6.68, 108.62], 
                        [-6.75, 108.63], [-6.82, 108.58], [-6.83, 108.48], 
                        [-6.78, 108.42], [-6.70, 108.41], [-6.65, 108.45]
                    ]
                },
                {
                    name: 'Kota Cirebon',
                    coords: [
                        [-6.730, 108.550], [-6.725, 108.560], [-6.735, 108.565], 
                        [-6.740, 108.562], [-6.742, 108.555], [-6.738, 108.548], 
                        [-6.732, 108.545], [-6.730, 108.550]
                    ]
                },
                {
                    name: 'Kuningan', 
                    coords: [
                        [-6.85, 108.35], [-6.82, 108.45], [-6.88, 108.55], 
                        [-6.95, 108.58], [-7.02, 108.52], [-7.05, 108.42], 
                        [-7.00, 108.32], [-6.92, 108.30], [-6.85, 108.35]
                    ]
                },
                {
                    name: 'Majalengka',
                    coords: [
                        [-6.72, 108.15], [-6.69, 108.25], [-6.75, 108.35], 
                        [-6.82, 108.38], [-6.89, 108.33], [-6.92, 108.23], 
                        [-6.87, 108.13], [-6.79, 108.11], [-6.72, 108.15]
                    ]
                },
                {
                    name: 'Indramayu',
                    coords: [
                        [-6.25, 107.95], [-6.22, 108.05], [-6.28, 108.15], 
                        [-6.35, 108.18], [-6.42, 108.13], [-6.45, 108.03], 
                        [-6.40, 107.93], [-6.32, 107.91], [-6.25, 107.95]
                    ]
                }
            ];
            
            boundaryShapes.forEach(shape => {
                const polygon = L.polygon(shape.coords, {
                    color: '#2980b9',
                    weight: 3,
                    opacity: 0.8,
                    fillColor: '#3498db',
                    fillOpacity: 0.15,
                    dashArray: '10, 5'
                });
                
                polygon.bindPopup(`
                    <div>
                        <h6><i class="fas fa-map"></i> ${shape.name}</h6>
                        <p class="mb-1"><strong>Type:</strong> Kabupaten</p>
                        <p class="mb-1"><strong>Province:</strong> Jawa Barat</p>
                        <p class="mb-0"><small class="text-info">Approximate Boundary</small></p>
                    </div>
                `);
                
                polygon.on('mouseover', function() {
                    this.setStyle({ weight: 5, fillOpacity: 0.3 });
                });
                
                polygon.on('mouseout', function() {
                    this.setStyle({ weight: 3, fillOpacity: 0.15 });
                });
                
                regionLayers.push(polygon);
                console.log(`✅ Added boundary shape for ${shape.name}`);
            });
        }
        
        console.log(`🎉 Loaded boundaries - Real data: ${realDataLoaded}`);
        return true;
    }

    // Add regions - only load boundary data, no center markers
    function addRegions() {
        console.log('Loading administrative boundaries...');
        
        // Load real geographic boundaries
        loadGADMBoundaries().then(() => {
            console.log('Geographic boundaries loaded successfully');
            if (regionsVisible) {
                regionLayers.forEach(layer => {
                    if (!myMap.hasLayer(layer)) {
                        layer.addTo(myMap);
                    }
                });
            }
        });
        
        console.log('Boundary loading initiated');
    }

    // Filter functions
    function applyFilters() {
        const nationality = document.getElementById('nationalityFilter').value;
        const status = document.getElementById('statusFilter').value;
        const residencePermitType = document.getElementById('residencePermitFilter').value;

        let filteredData = foreignersData;

        if (nationality) {
            filteredData = filteredData.filter(f => f.nationality === nationality);
        }
        if (status) {
            filteredData = filteredData.filter(f => f.status === status);
        }
        if (residencePermitType) {
            filteredData = filteredData.filter(f => f.residence_permit_type === residencePermitType);
        }

        addMarkers(filteredData);
    }

    function clearFilters() {
        document.getElementById('nationalityFilter').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('residencePermitFilter').value = '';
        addMarkers();
    }

    function updateMarkerCount(count) {
        document.getElementById('visibleMarkers').textContent = `${count} markers`;
    }

    // Function to create heatmap data from current markers
    function createHeatmapData(data = foreignersData) {
        const heatmapData = [];
        
        data.forEach(function(foreigner) {
            if (foreigner.latitude && foreigner.longitude) {
                const lat = parseFloat(foreigner.latitude);
                const lng = parseFloat(foreigner.longitude);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Add intensity based on status (active = higher intensity)
                    let intensity = 0.5; // default
                    if (foreigner.status === 'active') {
                        intensity = 1.0;
                    } else if (foreigner.status === 'departed') {
                        intensity = 0.2;
                    }
                    
                    heatmapData.push([lat, lng, intensity]);
                }
            }
        });
        
        // If no real data, add sample data for demonstration
        if (heatmapData.length === 0) {
            console.log('� No real coordinate data found, adding sample heatmap data for demonstration');
            heatmapData.push(
                [-6.7063, 108.5565, 1.0],  // Cirebon center - high intensity
                [-6.7100, 108.5600, 0.8],  // Near center
                [-6.7020, 108.5520, 0.6],  // Another area
                [-6.7150, 108.5480, 0.9],  // High density area
                [-6.7080, 108.5620, 0.7],  // Medium density
                [-6.7200, 108.5550, 0.4],  // Lower density
                [-6.7000, 108.5580, 0.5],  // Medium
                [-6.7120, 108.5500, 0.8],  // High
                [-6.7040, 108.5540, 0.6],  // Medium
                [-6.7180, 108.5580, 0.3]   // Low
            );
        }
        
        console.log('�📊 Created heatmap data points:', heatmapData.length);
        console.log('📊 Sample data:', heatmapData.slice(0, 3));
        return heatmapData;
    }

    // Function to create custom heatmap overlay using Canvas
    function createCustomHeatmap(data = foreignersData) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas size
        canvas.width = 512;
        canvas.height = 512;
        
        // Get map bounds and convert coordinates
        const bounds = myMap.getBounds();
        const mapSize = myMap.getSize();
        
        // Create data points for heatmap
        const heatPoints = [];
        data.forEach(function(foreigner) {
            if (foreigner.latitude && foreigner.longitude) {
                const lat = parseFloat(foreigner.latitude);
                const lng = parseFloat(foreigner.longitude);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Convert lat/lng to canvas coordinates
                    const point = myMap.latLngToLayerPoint([lat, lng]);
                    const intensity = foreigner.status === 'active' ? 1.0 : 0.5;
                    heatPoints.push({x: point.x, y: point.y, intensity: intensity});
                }
            }
        });
        
        // If no real data, add sample points
        if (heatPoints.length === 0) {
            const sampleCoords = [
                [-6.7063, 108.5565, 1.0],
                [-6.7100, 108.5600, 0.8],
                [-6.7020, 108.5520, 0.6],
                [-6.7150, 108.5480, 0.9],
                [-6.7080, 108.5620, 0.7]
            ];
            
            sampleCoords.forEach(coord => {
                const point = myMap.latLngToLayerPoint([coord[0], coord[1]]);
                heatPoints.push({x: point.x, y: point.y, intensity: coord[2]});
            });
        }
        
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw heat points
        heatPoints.forEach(point => {
            const radius = 40;
            const gradient = ctx.createRadialGradient(
                point.x % canvas.width, point.y % canvas.height, 0,
                point.x % canvas.width, point.y % canvas.height, radius
            );
            
            const alpha = point.intensity;
            gradient.addColorStop(0, `rgba(255, 0, 0, ${alpha})`);
            gradient.addColorStop(0.3, `rgba(255, 100, 0, ${alpha * 0.8})`);
            gradient.addColorStop(0.6, `rgba(255, 255, 0, ${alpha * 0.6})`);
            gradient.addColorStop(1, `rgba(0, 0, 255, 0)`);
            
            ctx.fillStyle = gradient;
            ctx.beginPath();
            ctx.arc(point.x % canvas.width, point.y % canvas.height, radius, 0, Math.PI * 2);
            ctx.fill();
        });
        
        return canvas;
    }

    // Function to toggle heatmap view
    function toggleHeatmap() {
        console.log('� Toggle heatmap clicked, current state:', heatmapEnabled);
        
        heatmapEnabled = !heatmapEnabled;
        
        if (heatmapEnabled) {
            try {
                // Remove regular markers
                if (clustersEnabled) {
                    myMap.removeLayer(clusterGroup);
                } else {
                    myMap.removeLayer(markerGroup);
                }
                
                // Try using L.heatLayer first if available
                if (typeof L.heatLayer !== 'undefined') {
                    console.log('✅ Using L.heatLayer');
                    const heatmapData = createHeatmapData();
                    
                    heatmapLayer = L.heatLayer(heatmapData, {
                        radius: 25,
                        blur: 15,
                        maxZoom: 17,
                        max: 1.0,
                        gradient: {
                            0.0: '#0000ff',  // blue
                            0.2: '#00ff00',  // green  
                            0.4: '#ffff00',  // yellow
                            0.6: '#ff8800',  // orange
                            0.8: '#ff4400',  // red-orange
                            1.0: '#ff0000'   // red
                        }
                    }).addTo(myMap);
                } else {
                    // Fallback: Use circle markers with opacity for heatmap effect
                    console.log('📍 Using fallback circle heatmap');
                    const heatData = createHeatmapData();
                    const heatGroup = L.layerGroup();
                    
                    heatData.forEach(point => {
                        const [lat, lng, intensity] = point;
                        const color = intensity > 0.7 ? '#ff0000' : 
                                     intensity > 0.5 ? '#ff8800' : 
                                     intensity > 0.3 ? '#ffff00' : '#0088ff';
                        
                        const circle = L.circle([lat, lng], {
                            color: color,
                            fillColor: color,
                            fillOpacity: intensity * 0.6,
                            radius: 100 + (intensity * 200),
                            weight: 0
                        });
                        
                        heatGroup.addLayer(circle);
                    });
                    
                    heatmapLayer = heatGroup;
                    heatmapLayer.addTo(myMap);
                }
                
                document.getElementById('toggleHeatmap').innerHTML = '<i class="fas fa-fire me-2"></i>Hide Heatmap';
                document.getElementById('toggleHeatmap').classList.add('active');
                
                console.log('🔥 Heatmap enabled successfully');
                
            } catch (error) {
                console.error('❌ Error creating heatmap:', error);
                alert('Error creating heatmap: ' + error.message);
                heatmapEnabled = false;
            }
        } else {
            // Remove heatmap layer and show markers again
            if (heatmapLayer) {
                try {
                    myMap.removeLayer(heatmapLayer);
                    heatmapLayer = null;
                    console.log('✅ Heatmap layer removed');
                } catch (error) {
                    console.error('❌ Error removing heatmap:', error);
                }
            }
            
            // Show regular markers again
            if (clustersEnabled) {
                myMap.addLayer(clusterGroup);
            } else {
                myMap.addLayer(markerGroup);
            }
            
            document.getElementById('toggleHeatmap').innerHTML = '<i class="fas fa-fire me-2"></i>Heatmap View';
            document.getElementById('toggleHeatmap').classList.remove('active');
            
            console.log('🔥 Heatmap layer disabled');
        }
    }

    // Event listeners
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('clearFilters').addEventListener('click', clearFilters);

    // Toggle Clusters
    document.getElementById('toggleClusters').addEventListener('click', function() {
        clustersEnabled = !clustersEnabled;
        
        if (clustersEnabled) {
            // Move markers from regular group to cluster group
            myMap.removeLayer(markerGroup);
            markerGroup.clearLayers();
            markers.forEach(marker => {
                clusterGroup.addLayer(marker);
            });
            myMap.addLayer(clusterGroup);
            this.innerHTML = '<i class="fas fa-layer-group me-2"></i>Hide Clusters';
        } else {
            // Move markers from cluster group back to regular group
            myMap.removeLayer(clusterGroup);
            clusterGroup.clearLayers();
            markers.forEach(marker => {
                markerGroup.addLayer(marker);
            });
            myMap.addLayer(markerGroup);
            this.innerHTML = '<i class="fas fa-layer-group me-2"></i>Show Clusters';
        }
        
        this.classList.toggle('active');
        console.log('Clusters enabled:', clustersEnabled);
    });

    // Toggle Regions
    document.getElementById('toggleRegions').addEventListener('click', function() {
        regionsVisible = !regionsVisible;
        console.log('Toggling regions, visible:', regionsVisible);
        console.log('Available region layers:', regionLayers.length);
        
        regionLayers.forEach(layer => {
            if (regionsVisible) {
                layer.addTo(myMap);
                this.innerHTML = '<i class="fas fa-map me-2"></i>Hide Regions';
            } else {
                myMap.removeLayer(layer);
                this.innerHTML = '<i class="fas fa-map me-2"></i>Show Regions';
            }
        });
        this.classList.toggle('active');
        console.log('Regions toggle completed');
    });

    // Fullscreen Map functionality
    document.getElementById('fullscreenMap').addEventListener('click', function() {
        const mapCard = document.querySelector('.card:has(#main-map)');
        const mapContainer = document.getElementById('main-map');
        const isFullscreen = document.body.classList.contains('map-fullscreen');
        
        if (!isFullscreen) {
            // Enter fullscreen
            document.body.classList.add('map-fullscreen');
            mapCard.classList.add('fullscreen-card');
            
            this.innerHTML = '<i class="fas fa-compress me-2"></i>Exit Fullscreen';
            this.classList.add('active');
            
            // Resize map after entering fullscreen
            setTimeout(() => {
                myMap.invalidateSize();
                console.log('Map resized for fullscreen');
            }, 200);
        } else {
            // Exit fullscreen
            document.body.classList.remove('map-fullscreen');
            mapCard.classList.remove('fullscreen-card');
            
            this.innerHTML = '<i class="fas fa-expand me-2"></i>Fullscreen';
            this.classList.remove('active');
            
            // Resize map after exiting fullscreen
            setTimeout(() => {
                myMap.invalidateSize();
                console.log('Map resized for normal view');
            }, 200);
        }
    });

    // Handle ESC key to exit fullscreen
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.body.classList.contains('map-fullscreen')) {
            document.getElementById('fullscreenMap').click();
        }
    });

        // Initialize map functionality
        addMarkers();
        addRegions(); // This will show the regions on the map

        // If we have real data, fit the map bounds to show all markers
        if (markers.length > 0) {
            console.log('Fitting map bounds to markers...');
            const group = new L.featureGroup(markers);
            myMap.fitBounds(group.getBounds().pad(0.1));
        }

        console.log('🎉 Map initialization completed successfully!');
        
    } catch (error) {
        console.error('💥 Critical map initialization error:', error);
        const mapContainer = document.getElementById('main-map');
        if (mapContainer) {
            mapContainer.innerHTML = `
                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-warning mb-3 error-icon"></i>
                        <h5>Map Loading Error</h5>
                        <p class="text-muted mb-3">Unable to initialize the interactive map.</p>
                        <button class="btn btn-primary" onclick="location.reload()">
                            <i class="fas fa-refresh me-2"></i>Reload Page
                        </button>
                        <div class="mt-3">
                            <small class="text-muted">Error: ${error.message}</small>
                        </div>
                    </div>
                </div>
            `;
        }
    }
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

.map-container {
    height: 500px;
    width: 100%;
}

.flag-emoji {
    font-size: 1.2em; 
    margin-right: 8px;
}

.flag-emoji-large {
    font-size: 1.5em;
}

.status-badge {
    color: white;
}

.status-badge-small {
    color: white; 
    font-size: 0.7em;
}

.error-icon {
    font-size: 3em;
}

.popup-details .row {
    margin-bottom: 0.25rem;
}

.popup-details .row:last-child {
    margin-bottom: 0;
}
</style>
@endpush

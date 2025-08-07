@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h1>
    </div>

    <!-- Statistics Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-compact primary border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-label">Total Foreigners</div>
                            <div class="stat-value">{{ number_format($stats['total_foreigners'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-compact success border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Active Permits</div>
                            <div class="stat-value">{{ number_format($stats['active_foreigners'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-compact danger border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Expired Permits</div>
                            <div class="stat-value">{{ number_format($stats['expired_residence_permits'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-compact warning border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="stat-label">Expiring Soon</div>
                            <div class="stat-value">{{ number_format($stats['expiring_soon'] ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Alerts & Activities -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-bell me-2"></i>Recent Alerts & Activities
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Urgent Notifications -->
                    @if(($stats['expired_permits'] ?? 0) > 0)
                    <div class="alert alert-danger mb-3" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">🚨 Urgent Action Required</h6>
                                <p class="mb-2">{{ $stats['expired_residence_permits'] }} residence permit(s) have expired and need immediate attention.</p>
                                <a href="/foreigners?filter=expired" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-eye me-1"></i>View Expired Permits
                                </a>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-clock me-1"></i>Last updated: {{ now()->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if(($stats['expiring_soon'] ?? 0) > 0)
                    <div class="alert alert-warning mb-3" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-clock me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">⚠️ Residence Permit Expiry Warning</h6>
                                <p class="mb-2">{{ $stats['expiring_soon'] }} residence permit(s) will expire within 30 days.</p>
                                <a href="/foreigners?filter=expiring" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-calendar-check me-1"></i>Review Expiring
                                </a>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-clock me-1"></i>Last updated: {{ now()->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- System Status -->
                    <div class="alert alert-success mb-3" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">✅ System Status</h6>
                                <p class="mb-2">Immigration database synchronized successfully. All systems operational.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-success">
                                            <i class="fas fa-database me-1"></i>Database: Online
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-success">
                                            <i class="fas fa-sync me-1"></i>Last sync: {{ now()->format('H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    @if(isset($recentForeigners) && $recentForeigners->count() > 0)
                    <div class="alert alert-info mb-0" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-user-plus me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">📋 Recent Activities</h6>
                                <p class="mb-2">{{ $recentForeigners->count() }} new registration(s) recorded recently.</p>
                                <a href="/foreigners" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-list me-1"></i>View All Records
                                </a>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-calendar me-1"></i>Latest: {{ $recentForeigners->first()->entry_date ? \Carbon\Carbon::parse($recentForeigners->first()->entry_date)->format('M d, Y') : 'N/A' }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-map-marker-alt me-2"></i>Foreigners Location Map
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div id="dashboardMap" style="height: 450px; width: 100%; border-radius: 0 0 0.375rem 0.375rem;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Entries -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-users me-2"></i>Recent Registrations
                    </h6>
                    <a href="/foreigners" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentForeigners) && $recentForeigners->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 border-0">Name</th>
                                    <th class="px-4 py-3 border-0">Country</th>
                                    <th class="px-4 py-3 border-0">Permit Type</th>
                                    <th class="px-4 py-3 border-0">Registration Date</th>
                                    <th class="px-4 py-3 border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentForeigners as $foreigner)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">{{ \App\Helpers\CountryHelper::getFlagEmoji($foreigner->nationality) }}</div>
                                            <strong>{{ $foreigner->first_name }} {{ $foreigner->last_name }}</strong>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">{{ $foreigner->nationality }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-primary">{{ $foreigner->residence_permit_type ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $foreigner->entry_date ? \Carbon\Carbon::parse($foreigner->entry_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($foreigner->residence_permit_expiry_date)
                                            @php
                                                $expiryDate = \Carbon\Carbon::parse($foreigner->residence_permit_expiry_date);
                                                $daysUntilExpiry = $expiryDate->diffInDays(now(), false);
                                            @endphp
                                            @if($daysUntilExpiry > 0)
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif($daysUntilExpiry >= -30)
                                                <span class="badge bg-warning">Expiring Soon</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">No Expiry</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0 fs-6">No recent registrations found</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>
<style>
    /* Statistics Cards */
    .stat-card-compact {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .stat-card-compact:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .stat-card-compact.primary {
        border-left: 4px solid #4e73df !important;
    }
    .stat-card-compact.success {
        border-left: 4px solid #1cc88a !important;
    }
    .stat-card-compact.danger {
        border-left: 4px solid #e74a3b !important;
    }
    .stat-card-compact.warning {
        border-left: 4px solid #f6c23e !important;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .stat-card-compact.primary .stat-icon {
        background: linear-gradient(135deg, rgba(78, 115, 223, 0.1), rgba(78, 115, 223, 0.2));
        color: #4e73df;
    }
    .stat-card-compact.success .stat-icon {
        background: linear-gradient(135deg, rgba(28, 200, 138, 0.1), rgba(28, 200, 138, 0.2));
        color: #1cc88a;
    }
    .stat-card-compact.danger .stat-icon {
        background: linear-gradient(135deg, rgba(231, 74, 59, 0.1), rgba(231, 74, 59, 0.2));
        color: #e74a3b;
    }
    .stat-card-compact.warning .stat-icon {
        background: linear-gradient(135deg, rgba(246, 194, 62, 0.1), rgba(246, 194, 62, 0.2));
        color: #f6c23e;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
        line-height: 1;
    }
    
    /* Card Improvements */
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid #e3e6f0 !important;
        background: linear-gradient(135deg, #f8f9fc, #ffffff) !important;
    }
    
    /* Map Container */
    #dashboardMap {
        border-radius: 0 0 0.75rem 0.75rem;
    }
    
    /* Table Improvements */
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        color: #5a5c69;
        background-color: #f8f9fc !important;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }
    
    /* Alert Improvements */
    .alert {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.075);
    }
    
    /* Button Improvements */
    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
    }
    
    /* Responsive Improvements */
    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        #dashboardMap {
            height: 300px !important;
        }
    }
    
    /* Chart Container Improvements */
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
// Dashboard Map Initialization
let dashboardMap;

// Helper function for country flag emojis
function getFlagEmoji(country) {
    const flagMap = {
        'Afghanistan': '🇦🇫', 'Albania': '🇦🇱', 'Algeria': '🇩🇿', 'Argentina': '🇦🇷', 'Armenia': '🇦🇲',
        'Australia': '🇦🇺', 'Austria': '🇦🇹', 'Azerbaijan': '🇦🇿', 'Bahrain': '🇧🇭', 'Bangladesh': '🇧🇩',
        'Belarus': '🇧🇾', 'Belgium': '🇧🇪', 'Brazil': '🇧🇷', 'Bulgaria': '🇧🇬', 'Cambodia': '🇰🇭',
        'Canada': '🇨🇦', 'Chile': '🇨🇱', 'China': '🇨🇳', 'Colombia': '🇨🇴', 'Croatia': '🇭🇷',
        'Czech Republic': '🇨🇿', 'Denmark': '🇩🇰', 'Egypt': '🇪🇬', 'Estonia': '🇪🇪', 'Ethiopia': '🇪🇹',
        'Finland': '🇫🇮', 'France': '🇫🇷', 'Georgia': '🇬🇪', 'Germany': '🇩🇪', 'Ghana': '🇬🇭',
        'Greece': '🇬🇷', 'Hungary': '🇭🇺', 'Iceland': '🇮🇸', 'India': '🇮🇳', 'Indonesia': '🇮🇩',
        'Iran': '🇮🇷', 'Iraq': '🇮🇶', 'Ireland': '🇮🇪', 'Israel': '🇮🇱', 'Italy': '🇮🇹',
        'Japan': '🇯🇵', 'Jordan': '🇯🇴', 'Kazakhstan': '🇰🇿', 'Kenya': '🇰🇪', 'Kuwait': '🇰🇼',
        'Latvia': '🇱🇻', 'Lebanon': '🇱🇧', 'Lithuania': '🇱🇹', 'Malaysia': '🇲🇾', 'Mexico': '🇲🇽',
        'Morocco': '🇲🇦', 'Netherlands': '🇳🇱', 'New Zealand': '🇳🇿', 'Nigeria': '🇳🇬', 'Norway': '🇳🇴',
        'Pakistan': '🇵🇰', 'Philippines': '🇵🇭', 'Poland': '🇵🇱', 'Portugal': '🇵🇹', 'Qatar': '🇶🇦',
        'Romania': '🇷🇴', 'Russia': '🇷🇺', 'Saudi Arabia': '🇸🇦', 'Singapore': '🇸🇬', 'Slovakia': '🇸🇰',
        'Slovenia': '🇸🇮', 'South Africa': '🇿🇦', 'South Korea': '🇰🇷', 'Spain': '🇪🇸', 'Sri Lanka': '🇱🇰',
        'Sweden': '🇸🇪', 'Switzerland': '🇨🇭', 'Syria': '🇸🇾', 'Taiwan': '🇹🇼', 'Thailand': '🇹🇭',
        'Turkey': '🇹🇷', 'Ukraine': '🇺🇦', 'United Arab Emirates': '🇦🇪', 'United Kingdom': '🇬🇧',
        'United States': '🇺🇸', 'Uzbekistan': '🇺🇿', 'Vietnam': '🇻🇳', 'Yemen': '🇾🇪'
    };
    return flagMap[country] || '🏳️';
}

document.addEventListener('DOMContentLoaded', function() {
    // Get chart data
    const residencePermitTypesData = @json($residencePermitTypes ?? []);
    const monthlyData = @json($monthlyStats ?? []);
    
    // Initialize Dashboard Map
    dashboardMap = L.map('dashboardMap').setView([-2.5489, 118.0149], 5); // Indonesia center
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(dashboardMap);

    // Add foreigners markers to dashboard map
    const foreignersData = @json($foreignersForMap ?? []);
    
    if (foreignersData && foreignersData.length > 0) {
        foreignersData.forEach(function(foreigner) {
            if (foreigner.latitude && foreigner.longitude) {
                const flag = getFlagEmoji(foreigner.nationality);
                
                // Status-based marker color
                let markerColor = 'blue';
                if (foreigner.residence_permit_expiry_date) {
                    const expiryDate = new Date(foreigner.residence_permit_expiry_date);
                    const now = new Date();
                    const daysUntilExpiry = Math.ceil((expiryDate - now) / (1000 * 60 * 60 * 24));
                    
                    if (daysUntilExpiry < 0) {
                        markerColor = 'red'; // Expired
                    } else if (daysUntilExpiry <= 30) {
                        markerColor = 'orange'; // Expiring soon
                    } else {
                        markerColor = 'green'; // Active
                    }
                }
                
                const marker = L.circleMarker([foreigner.latitude, foreigner.longitude], {
                    radius: 6,
                    fillColor: markerColor,
                    color: '#fff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(dashboardMap);
                
                const popupContent = `
                    <div class="popup-content">
                        <h6 class="mb-2">${flag} ${foreigner.first_name} ${foreigner.last_name}</h6>
                        <p class="mb-1"><strong>Nationality:</strong> ${foreigner.nationality}</p>
                        <p class="mb-1"><strong>Residence Permit Type:</strong> ${foreigner.residence_permit_type || 'N/A'}</p>
                        <p class="mb-1"><strong>Location:</strong> ${foreigner.city || 'Unknown'}</p>
                        <p class="mb-0"><strong>Status:</strong> 
                            <span class="badge bg-${markerColor === 'red' ? 'danger' : markerColor === 'orange' ? 'warning' : 'success'}">
                                ${markerColor === 'red' ? 'Expired' : markerColor === 'orange' ? 'Expiring Soon' : 'Active'}
                            </span>
                        </p>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
            }
        });
    }
});
</script>
@endpush

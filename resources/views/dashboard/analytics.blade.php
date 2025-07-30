@extends('layouts.app')

@section('title', 'Analitik - SIMWNA Kantor Imigrasi Kelas I TPI Cirebon')
@section('page-title', 'Analitik & Laporan')

@section('page-actions')
<div class="btn-group" role="group">
    <button type="button" class="btn btn-outline-primary" onclick="window.print()">
        <i class="fas fa-print me-2"></i>Cetak Laporan
    </button>
    <button type="button" class="btn btn-outline-primary" id="exportData">
        <i class="fas fa-download me-2"></i>Ekspor Data
    </button>
</div>
@endsection

@section('content')
<!-- Visa Expiry Alerts -->
@if($upcomingExpirations->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            <h5 class="alert-heading">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Peringatan Kedaluwarsa Visa
            </h5>
            <p>{{ $upcomingExpirations->count() }} visa akan kedaluwarsa dalam 30 hari ke depan.</p>
            <hr>
            <div class="row">
                @foreach($upcomingExpirations->take(3) as $expiring)
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-clock text-warning me-2"></i>
                        <div>
                            <strong>{{ $expiring->full_name }}</strong><br>
                            <small>Expires: {{ \App\Helpers\DateHelper::formatIndonesian($expiring->visa_expiry_date, 'd F Y') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($upcomingExpirations->count() > 3)
            <p class="mb-0 mt-2">
                <a href="{{ route('foreigners.index') }}?filter=expiring" class="alert-link">
                    View all {{ $upcomingExpirations->count() }} expiring visas
                </a>
            </p>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Charts Row 1 -->
<div class="row mb-4">
    <!-- Monthly Entry Trends -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>
                    Monthly Entry Trends (Last 12 Months)
                </h6>
            </div>
            <div class="card-body">
                <canvas id="monthlyTrendsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Gender Distribution -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-venus-mars me-2"></i>
                    Gender Distribution
                </h6>
            </div>
            <div class="card-body">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="row mb-4">
    <!-- Age Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-birthday-cake me-2"></i>
                    Age Group Distribution
                </h6>
            </div>
            <div class="card-body">
                <canvas id="ageChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming Expirations List -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Upcoming Visa Expirations
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Nationality</th>
                                <th>Expiry Date</th>
                                <th>Days Left</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingExpirations->take(10) as $expiring)
                            <tr>
                                <td>
                                    <a href="{{ route('foreigners.show', $expiring) }}" class="text-decoration-none">
                                        {{ $expiring->full_name }}
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ \App\Helpers\CountryHelper::getFlagUrl($expiring->nationality) }}" 
                                         class="nationality-flag me-1" 
                                         alt="{{ $expiring->nationality }}"
                                         style="width: 20px; height: 15px; object-fit: cover; vertical-align: middle;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                    <span style="display: none; font-size: 14px;">{{ \App\Helpers\CountryHelper::getFlagEmoji($expiring->nationality) }}</span>
                                    {{ $expiring->nationality }}
                                </td>
                                <td>{{ \App\Helpers\DateHelper::formatIndonesian($expiring->visa_expiry_date, 'd F Y') }}</td>
                                <td>
                                    @php
                                        $daysLeft = floor(now()->diffInDays($expiring->visa_expiry_date));
                                    @endphp
                                    <span class="badge bg-{{ $daysLeft <= 7 ? 'danger' : ($daysLeft <= 14 ? 'warning' : 'info') }}">
                                        {{ $daysLeft }} hari
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No upcoming expirations</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>
                    Summary Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="border-start border-primary ps-3">
                            <div class="text-primary">Average Stay Duration</div>
                            <div class="h5 mb-0">
                                @php
                                    $avgStay = \App\Models\Foreigner::whereNotNull('entry_date')
                                        ->selectRaw('AVG(CURRENT_DATE - entry_date) as avg_days')
                                        ->first();
                                    echo $avgStay && $avgStay->avg_days ? round($avgStay->avg_days) . ' days' : 'N/A';
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border-start border-success ps-3">
                            <div class="text-success">Most Common Visa Type</div>
                            <div class="h6 mb-0">
                                @php
                                    $commonVisa = \App\Models\Foreigner::selectRaw('visa_type, COUNT(*) as count')
                                        ->groupBy('visa_type')
                                        ->orderBy('count', 'desc')
                                        ->first();
                                    echo $commonVisa ? $commonVisa->visa_type : 'N/A';
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border-start border-info ps-3">
                            <div class="text-info">Most Common Nationality</div>
                            <div class="h6 mb-0">
                                @php
                                    $commonNationality = \App\Models\Foreigner::selectRaw('nationality, COUNT(*) as count')
                                        ->groupBy('nationality')
                                        ->orderBy('count', 'desc')
                                        ->first();
                                @endphp
                                @if($commonNationality)
                                    <img src="{{ \App\Helpers\CountryHelper::getFlagUrl($commonNationality->nationality) }}" 
                                         class="nationality-flag me-1" 
                                         alt="{{ $commonNationality->nationality }}"
                                         style="width: 20px; height: 15px; object-fit: cover; vertical-align: middle;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                    <span style="display: none; font-size: 14px;">{{ \App\Helpers\CountryHelper::getFlagEmoji($commonNationality->nationality) }}</span>
                                    {{ $commonNationality->nationality }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border-start border-warning ps-3">
                            <div class="text-warning">Peak Entry Month</div>
                            <div class="h6 mb-0">
                                @php
                                    $peakMonth = \App\Models\Foreigner::whereNotNull('entry_date')
                                        ->selectRaw('EXTRACT(MONTH FROM entry_date) as month, COUNT(*) as count')
                                        ->groupBy('month')
                                        ->orderBy('count', 'desc')
                                        ->first();
                                    
                                    if ($peakMonth) {
                                        $monthNames = [
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        ];
                                        echo $monthNames[$peakMonth->month] ?? 'N/A';
                                    } else {
                                        echo 'N/A';
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Trends Chart
    const monthlyData = @json($monthlyEntries);
    const monthlyLabels = monthlyData.map(item => {
        const date = new Date(item.year, item.month - 1);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
    }).reverse();
    const monthlyCounts = monthlyData.map(item => item.count).reverse();

    new Chart(document.getElementById('monthlyTrendsChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'New Entries',
                data: monthlyCounts,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Gender Chart
    const genderData = @json($genderStats);
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: genderData.map(item => item.gender.charAt(0).toUpperCase() + item.gender.slice(1)),
            datasets: [{
                data: genderData.map(item => item.count),
                backgroundColor: ['#007bff', '#28a745', '#ffc107']
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

    // Age Chart
    const ageData = @json($ageStats);
    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: ageData.map(item => item.age_group),
            datasets: [{
                label: 'Count',
                data: ageData.map(item => item.count),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', 
                    '#4BC0C0', '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Export functionality
    document.getElementById('exportData').addEventListener('click', function() {
        // This would trigger a download of the data
        // For now, we'll just show an alert
        alert('Export functionality would be implemented here. This would generate a CSV or Excel file with the analytics data.');
    });
});
</script>
@endpush

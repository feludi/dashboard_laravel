<?php

namespace App\Http\Controllers;

use App\Models\Foreigner;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Using cache to speed things up - dashboard gets hit a lot
            $stats = Cache::remember('dashboard_stats', config('app_optimization.cache.dashboard_stats', 3600), function () {
                return $this->getDirectStats();
            });

            // Cache residence permit type stats for charts
            $residencePermitTypes = Cache::remember('residence_permit_type_stats', config('app_optimization.cache.analytics_data', 1800), function () {
                return Foreigner::select('residence_permit_type', DB::raw('count(*) as count'))
                    ->whereNotNull('residence_permit_type')
                    ->groupBy('residence_permit_type')
                    ->orderBy('count', 'desc')
                    ->get()
                    ->pluck('count', 'residence_permit_type')
                    ->toArray();
            });

            // Monthly registration trends
            $monthlyStats = Cache::remember('monthly_stats', config('app_optimization.cache.analytics_data', 1800), function () {
                return Foreigner::select(
                    DB::raw('EXTRACT(YEAR FROM entry_date) as year'),
                    DB::raw('EXTRACT(MONTH FROM entry_date) as month'),
                    DB::raw('count(*) as count')
                )
                ->whereNotNull('entry_date')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->limit(12)
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                        'count' => (int) $item->count,
                        'year' => (int) $item->year,
                        'month_num' => (int) $item->month
                    ];
                })
                ->sortBy(function($item) {
                    return $item['year'] * 100 + $item['month_num'];
                })
                ->values()
                ->toArray();
            });

            // Recent foreigners
            $recentForeigners = Cache::remember('recent_foreigners', config('app_optimization.cache.analytics_data', 1800), function () {
                return Foreigner::select(['id', 'first_name', 'last_name', 'nationality', 'residence_permit_type', 'residence_permit_expiry_date', 'entry_date', 'created_at'])
                    ->orderBy('entry_date', 'desc')
                    ->whereNotNull('entry_date')
                    ->limit(5)
                    ->get();
            });

            // Optimized foreigners for map with caching
            $foreignersForMap = Cache::remember('foreigners_map_data', config('app_optimization.cache.analytics_data', 1800), function () {
                return Foreigner::withCoordinates()
                    ->select(['id', 'first_name', 'last_name', 'nationality', 'residence_permit_type', 'status', 'residence_permit_expiry_date', 'latitude', 'longitude', 'city'])
                    ->get();
            });

            return view('dashboard.index', compact(
                'stats',
                'residencePermitTypes',
                'monthlyStats',
                'recentForeigners',
                'foreignersForMap'
            ));

        } catch (\Exception $e) {
            Log::error('Dashboard loading error', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            // Fallback to basic stats if caching fails
            $stats = $this->getDirectStats();
            $residencePermitTypes = [];
            $monthlyStats = [];
            $recentForeigners = collect([]);
            $foreignersForMap = collect([]);

            return view('dashboard.index', compact(
                'stats',
                'permitTypes',
                'monthlyStats',
                'recentForeigners',
                'foreignersForMap'
            ))->with('warning', 'Some dashboard features may be limited.');
        }
    }

    public function map()
    {
        // Check if user can view maps
        $currentUser = \App\Http\Controllers\AuthController::user();
        if (!$currentUser || !is_object($currentUser) || !$currentUser->canViewMaps()) {
            abort(403, 'You do not have permission to view maps.');
        }

        // Get all foreigners with coordinates for map popup (not just active ones)
        $foreigners = Foreigner::withCoordinates()
            ->select([
                'id', 'first_name', 'last_name', 'nationality', 'residence_permit_type', 'status',
                'city', 'state_province', 'passport_number', 'entry_date', 'residence_permit_expiry_date',
                'latitude', 'longitude'
            ])
            ->get();

        // Get regions with basic data only
        $regions = Region::select(['id', 'name', 'code', 'country', 'latitude', 'longitude'])
            ->get()
            ->map(function ($region) {
                return [
                    'id' => $region->id,
                    'name' => $region->name,
                    'code' => $region->code,
                    'country' => $region->country,
                    'latitude' => $region->latitude,
                    'longitude' => $region->longitude
                ];
            })
            ->toArray();

        return view('dashboard.map', compact('foreigners', 'regions'));
    }

    public function analytics()
    {
        // Monthly entry trends (PostgreSQL compatible)
        $monthlyEntries = Foreigner::select(
            DB::raw('EXTRACT(YEAR FROM entry_date) as year'),
            DB::raw('EXTRACT(MONTH FROM entry_date) as month'),
            DB::raw('count(*) as count')
        )
        ->whereNotNull('entry_date')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        // Residence permit expiry alerts (next 30 days)
        $upcomingExpirations = Foreigner::where('residence_permit_expiry_date', '>=', now())
            ->where('residence_permit_expiry_date', '<=', now()->addDays(30))
            ->where('status', 'active')
            ->orderBy('residence_permit_expiry_date')
            ->get();

        // Gender distribution
        $genderStats = Foreigner::select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();

        // Age distribution (PostgreSQL compatible)
        $ageStats = Foreigner::select(
            DB::raw('CASE 
                WHEN EXTRACT(YEAR FROM CURRENT_DATE) - EXTRACT(YEAR FROM date_of_birth) < 18 THEN \'Under 18\'
                WHEN EXTRACT(YEAR FROM CURRENT_DATE) - EXTRACT(YEAR FROM date_of_birth) BETWEEN 18 AND 25 THEN \'18-25\'
                WHEN EXTRACT(YEAR FROM CURRENT_DATE) - EXTRACT(YEAR FROM date_of_birth) BETWEEN 26 AND 35 THEN \'26-35\'
                WHEN EXTRACT(YEAR FROM CURRENT_DATE) - EXTRACT(YEAR FROM date_of_birth) BETWEEN 36 AND 50 THEN \'36-50\'
                ELSE \'Over 50\'
            END as age_group'),
            DB::raw('count(*) as count')
        )
        ->whereNotNull('date_of_birth')
        ->groupBy('age_group')
        ->get();

        // Residence permit types distribution
        $residencePermitTypes = Foreigner::select('residence_permit_type')
            ->selectRaw('COUNT(*) as count')
            ->whereNotNull('residence_permit_type')
            ->groupBy('residence_permit_type')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'residence_permit_type')
            ->toArray();

        return view('dashboard.analytics', compact(
            'monthlyEntries',
            'upcomingExpirations',
            'genderStats',
            'ageStats',
            'residencePermitTypes'
        ));
    }

    /**
     * Fallback method for direct database stats when cache service is unavailable
     */
    private function getDirectStats(): array
    {
        return [
            'total_foreigners' => Foreigner::count(),
            'active_foreigners' => Foreigner::active()->count(),
            'expired_residence_permits' => Foreigner::expiredResidencePermit()->count(),
            'expiring_soon' => Foreigner::expiringResidencePermit(30)->count(),
            'by_nationality' => Foreigner::select('nationality')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('nationality')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
                ->toArray(),
            'by_region' => Foreigner::select('city')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('city')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
                ->toArray(),
            'recent_entries' => Foreigner::select(['id', 'first_name', 'last_name', 'nationality', 'entry_date'])
                ->whereNotNull('entry_date')
                ->orderByDesc('entry_date')
                ->limit(5)
                ->get()
                ->toArray(),
        ];
    }
}

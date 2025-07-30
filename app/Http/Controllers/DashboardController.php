<?php

namespace App\Http\Controllers;

use App\Models\Foreigner;
use App\Models\Region;
use App\Services\DashboardCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Always use fallback for now to ensure stability
        $stats = $this->getDirectStats();

        // Visa type distribution
        $visaTypeStats = Foreigner::select('visa_type', DB::raw('count(*) as count'))
            ->groupBy('visa_type')
            ->orderBy('count', 'desc')
            ->get();

        // Foreigners with coordinates for mapping (optimized query)
        $foreignersForMap = Foreigner::withCoordinates()
            ->active()
            ->select(['id', 'first_name', 'last_name', 'nationality', 'latitude', 'longitude', 'city'])
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'visaTypeStats', 
            'foreignersForMap'
        ));
    }

    public function map()
    {
        // Use optimized query with select only needed fields
        $foreigners = Foreigner::withCoordinates()
            ->active()
            ->select(['id', 'first_name', 'last_name', 'nationality', 'latitude', 'longitude', 'city'])
            ->get();

        // Use direct query for regions
        $regions = Region::select(['id', 'name', 'country'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return view('dashboard.map', compact('foreigners', 'regions'));
    }    public function analytics()
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

        // Visa expiry alerts (next 30 days)
        $upcomingExpirations = Foreigner::where('visa_expiry_date', '>=', now())
            ->where('visa_expiry_date', '<=', now()->addDays(30))
            ->where('status', 'active')
            ->orderBy('visa_expiry_date')
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

        return view('dashboard.analytics', compact(
            'monthlyEntries',
            'upcomingExpirations',
            'genderStats',
            'ageStats'
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
            'expired_visas' => Foreigner::expiredVisa()->count(),
            'expiring_soon' => Foreigner::expiringVisa(30)->count(),
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

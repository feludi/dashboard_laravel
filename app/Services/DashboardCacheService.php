<?php

namespace App\Services;

use App\Models\Foreigner;
use App\Models\Region;
use Illuminate\Support\Facades\Cache;

class DashboardCacheService
{
    /**
     * Cache duration in minutes
     */
    private const CACHE_DURATION = 60;

    /**
     * Get cached dashboard statistics
     */
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard_stats', self::CACHE_DURATION, function () {
            return [
                'total_foreigners' => Foreigner::count(),
                'active_foreigners' => Foreigner::active()->count(),
                'expired_visas' => Foreigner::expiredVisa()->count(),
                'expiring_soon' => Foreigner::expiringVisa(30)->count(),
                'by_nationality' => $this->getNationalityStats(),
                'by_region' => $this->getRegionStats(),
                'recent_entries' => $this->getRecentEntries(),
            ];
        });
    }

    /**
     * Get nationality statistics
     */
    private function getNationalityStats(): array
    {
        return Cache::remember('nationality_stats', self::CACHE_DURATION, function () {
            return Foreigner::select('nationality')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('nationality')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
                ->toArray();
        });
    }

    /**
     * Get region statistics
     */
    private function getRegionStats(): array
    {
        return Cache::remember('region_stats', self::CACHE_DURATION, function () {
            return Foreigner::select('city')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('city')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
                ->toArray();
        });
    }

    /**
     * Get recent entries
     */
    private function getRecentEntries(): array
    {
        return Cache::remember('recent_entries', 30, function () {
            return Foreigner::select(['id', 'first_name', 'last_name', 'nationality', 'entry_date'])
                ->whereNotNull('entry_date')
                ->orderByDesc('entry_date')
                ->limit(5)
                ->get()
                ->toArray();
        });
    }

    /**
     * Get cached regions list
     */
    public function getRegions(): array
    {
        return Cache::remember('regions_list', 120, function () {
            return Region::select(['id', 'name', 'country'])
                ->orderBy('name')
                ->get()
                ->toArray();
        });
    }

    /**
     * Get cached nationality list
     */
    public function getNationalities(): array
    {
        return Cache::remember('nationalities_list', 120, function () {
            return Foreigner::select('nationality')
                ->distinct()
                ->whereNotNull('nationality')
                ->orderBy('nationality')
                ->pluck('nationality')
                ->toArray();
        });
    }

    /**
     * Clear all dashboard caches
     */
    public function clearCache(): void
    {
        $keys = [
            'dashboard_stats',
            'nationality_stats',
            'region_stats',
            'recent_entries',
            'regions_list',
            'nationalities_list'
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Refresh dashboard cache
     */
    public function refreshCache(): array
    {
        $this->clearCache();
        return $this->getDashboardStats();
    }
}

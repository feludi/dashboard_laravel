<?php

namespace App\Console\Commands;

use App\Services\DashboardCacheService;
use Illuminate\Console\Command;

class WarmupCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warmup:cache {--force : Force refresh all caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application caches for better performance';

    /**
     * Execute the console command.
     */
    public function handle(DashboardCacheService $cacheService)
    {
        $this->info('🔥 Warming up application caches...');

        try {
            if ($this->option('force')) {
                $this->info('🗑️  Clearing existing caches...');
                $cacheService->clearCache();
            }

            $this->info('📊 Loading dashboard statistics...');
            $stats = $cacheService->getDashboardStats();
            
            $this->info('🌍 Loading regions data...');
            $regions = $cacheService->getRegions();
            
            $this->info('🏳️ Loading nationalities data...');
            $nationalities = $cacheService->getNationalities();

            $this->info('✅ Cache warmup completed successfully!');
            $this->newLine();
            
            $this->table(
                ['Cache Key', 'Status', 'Records'],
                [
                    ['Dashboard Stats', '✅ Cached', count($stats)],
                    ['Regions', '✅ Cached', count($regions)],
                    ['Nationalities', '✅ Cached', count($nationalities)],
                ]
            );

            $this->info('🚀 Application performance improved!');
            
        } catch (\Exception $e) {
            $this->error('❌ Cache warmup failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

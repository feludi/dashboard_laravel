<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Foreigner;
use Carbon\Carbon;

class UpdatePermitStatuses extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'permits:update-statuses 
                            {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     */
    protected $description = 'Automatically update residence permit statuses based on expiry dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $today = Carbon::today();
        $in30Days = $today->copy()->addDays(30);
        
        $this->info('Starting residence permit status update...');
        $this->info('Current date: ' . $today->format('Y-m-d'));
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        // Update expired permits (excluding ITAP permanent permits)
        $expiredCount = $this->updateExpiredPermits($today, $dryRun);
        
        // Update expiring soon permits (excluding ITAP permanent permits)
        $expiringSoonCount = $this->updateExpiringSoonPermits($today, $in30Days, $dryRun);
        
        // Reset active status for permits that are no longer expiring soon
        $resetCount = $this->resetNonExpiring($in30Days, $dryRun);

        $this->newLine();
        $this->info('Summary:');
        $this->line("  - Permits marked as expired: {$expiredCount}");
        $this->line("  - Permits marked as expiring soon: {$expiringSoonCount}");
        $this->line("  - Permits reset to active: {$resetCount}");
        
        if (!$dryRun) {
            $this->info('Status update completed successfully!');
        } else {
            $this->warn('This was a dry run. Use without --dry-run to apply changes.');
        }
    }

    /**
     * Update permits that have expired
     */
    private function updateExpiredPermits($today, $dryRun)
    {
        $expiredPermits = Foreigner::where('residence_permit_type', '!=', 'ITAP')
            ->where('residence_permit_expiry_date', '<', $today)
            ->where('status', '!=', 'expired')
            ->whereNotNull('residence_permit_expiry_date');

        $count = $expiredPermits->count();
        
        if ($count > 0) {
            $this->line("\nFound {$count} permits that have expired:");
            
            $expiredPermits->chunk(50, function ($permits) use ($dryRun) {
                foreach ($permits as $permit) {
                    $this->line("  - {$permit->full_name} (Passport: {$permit->passport_number}) - Expired: {$permit->residence_permit_expiry_date->format('Y-m-d')}");
                    
                    if (!$dryRun) {
                        $permit->update(['status' => 'expired']);
                    }
                }
            });
        }
        
        return $count;
    }

    /**
     * Update permits that are expiring within 30 days
     */
    private function updateExpiringSoonPermits($today, $in30Days, $dryRun)
    {
        $expiringSoonPermits = Foreigner::where('residence_permit_type', '!=', 'ITAP')
            ->whereBetween('residence_permit_expiry_date', [$today, $in30Days])
            ->where('status', 'active')
            ->whereNotNull('residence_permit_expiry_date');

        $count = $expiringSoonPermits->count();
        
        if ($count > 0) {
            $this->line("\nFound {$count} permits expiring within 30 days:");
            
            $expiringSoonPermits->chunk(50, function ($permits) use ($dryRun) {
                foreach ($permits as $permit) {
                    $daysLeft = Carbon::today()->diffInDays($permit->residence_permit_expiry_date, false);
                    $this->line("  - {$permit->full_name} (Passport: {$permit->passport_number}) - Expires in {$daysLeft} days ({$permit->residence_permit_expiry_date->format('Y-m-d')})");
                    
                    if (!$dryRun) {
                        $permit->update(['status' => 'expiring_soon']);
                    }
                }
            });
        }
        
        return $count;
    }

    /**
     * Reset permits that are no longer expiring soon back to active
     */
    private function resetNonExpiring($in30Days, $dryRun)
    {
        $nonExpiringPermits = Foreigner::where('residence_permit_type', '!=', 'ITAP')
            ->where('residence_permit_expiry_date', '>', $in30Days)
            ->where('status', 'expiring_soon')
            ->whereNotNull('residence_permit_expiry_date');

        $count = $nonExpiringPermits->count();
        
        if ($count > 0) {
            $this->line("\nFound {$count} permits to reset back to active status:");
            
            $nonExpiringPermits->chunk(50, function ($permits) use ($dryRun) {
                foreach ($permits as $permit) {
                    $daysLeft = Carbon::today()->diffInDays($permit->residence_permit_expiry_date, false);
                    $this->line("  - {$permit->full_name} (Passport: {$permit->passport_number}) - Now expires in {$daysLeft} days");
                    
                    if (!$dryRun) {
                        $permit->update(['status' => 'active']);
                    }
                }
            });
        }
        
        return $count;
    }
}

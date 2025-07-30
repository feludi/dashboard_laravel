<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('foreigners', function (Blueprint $table) {
            // Add indexes for frequently searched columns
            $table->index('nationality', 'idx_foreigners_nationality');
            $table->index('status', 'idx_foreigners_status');
            $table->index('city', 'idx_foreigners_city');
            $table->index('visa_expiry_date', 'idx_foreigners_visa_expiry');
            $table->index('entry_date', 'idx_foreigners_entry_date');
            $table->index(['latitude', 'longitude'], 'idx_foreigners_coordinates');
            
            // Composite index for common queries
            $table->index(['status', 'nationality'], 'idx_foreigners_status_nationality');
            $table->index(['city', 'status'], 'idx_foreigners_city_status');
        });

        Schema::table('movements', function (Blueprint $table) {
            // Add indexes for movement tracking
            $table->index('foreigner_id', 'idx_movements_foreigner');
            $table->index('movement_date', 'idx_movements_date');
            $table->index('movement_type', 'idx_movements_type');
            $table->index(['foreigner_id', 'movement_date'], 'idx_movements_foreigner_date');
        });

        Schema::table('users', function (Blueprint $table) {
            // Add index for email lookups (if not already unique)
            $table->index('email', 'idx_users_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreigners', function (Blueprint $table) {
            $table->dropIndex('idx_foreigners_nationality');
            $table->dropIndex('idx_foreigners_status');
            $table->dropIndex('idx_foreigners_city');
            $table->dropIndex('idx_foreigners_visa_expiry');
            $table->dropIndex('idx_foreigners_entry_date');
            $table->dropIndex('idx_foreigners_coordinates');
            $table->dropIndex('idx_foreigners_status_nationality');
            $table->dropIndex('idx_foreigners_city_status');
        });

        Schema::table('movements', function (Blueprint $table) {
            $table->dropIndex('idx_movements_foreigner');
            $table->dropIndex('idx_movements_date');
            $table->dropIndex('idx_movements_type');
            $table->dropIndex('idx_movements_foreigner_date');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_email');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add additional indexes for better performance
        Schema::table('foreigners', function (Blueprint $table) {
            // Search indexes
            $table->index(['nationality', 'status'], 'idx_nationality_status');
            $table->index(['visa_type', 'visa_status'], 'idx_visa_type_status');
            $table->index(['city', 'state_province'], 'idx_location');
            $table->index(['created_at', 'status'], 'idx_created_status');
            $table->index(['visa_expiry_date'], 'idx_visa_expiry');
            
            // Full text search indexes (if PostgreSQL supports it)
            if (config('database.default') === 'pgsql') {
                $table->index(['first_name', 'last_name'], 'idx_full_name');
            }
        });

        // Add indexes to regions table
        Schema::table('regions', function (Blueprint $table) {
            $table->index(['name'], 'idx_region_name');
            $table->index(['country'], 'idx_region_country');
        });
    }

    public function down()
    {
        Schema::table('foreigners', function (Blueprint $table) {
            $table->dropIndex('idx_nationality_status');
            $table->dropIndex('idx_visa_type_status');
            $table->dropIndex('idx_location');
            $table->dropIndex('idx_created_status');
            $table->dropIndex('idx_visa_expiry');
            $table->dropIndex('idx_full_name');
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->dropIndex('idx_region_name');
            $table->dropIndex('idx_region_country');
        });
    }
};

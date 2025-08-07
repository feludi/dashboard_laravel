<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('foreigners', function (Blueprint $table) {
            // Rename visa-related columns to residence permit columns
            $table->renameColumn('visa_type', 'residence_permit_type');
            $table->renameColumn('visa_status', 'residence_permit_status');
            $table->renameColumn('visa_issue_date', 'residence_permit_issue_date');
            $table->renameColumn('visa_expiry_date', 'residence_permit_expiry_date');
            
            // Rename emergency contact to sponsor contact
            $table->renameColumn('emergency_contact_name', 'sponsor_contact_name');
            $table->renameColumn('emergency_contact_phone', 'sponsor_contact_number');
        });
        
        // Update existing data to new residence permit types
        DB::table('foreigners')->update([
            'residence_permit_type' => DB::raw("
                CASE 
                    WHEN residence_permit_type IN ('B211A', 'B212A', 'B213A') THEN 'ITK'
                    WHEN residence_permit_type IN ('B211B', 'B212B', 'B213B') THEN 'ITAS'
                    ELSE 'other'
                END
            ")
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreigners', function (Blueprint $table) {
            // Rename back to original names
            $table->renameColumn('residence_permit_type', 'visa_type');
            $table->renameColumn('residence_permit_status', 'visa_status');
            $table->renameColumn('residence_permit_issue_date', 'visa_issue_date');
            $table->renameColumn('residence_permit_expiry_date', 'visa_expiry_date');
            
            // Rename back emergency contact columns
            $table->renameColumn('sponsor_contact_name', 'emergency_contact_name');
            $table->renameColumn('sponsor_contact_number', 'emergency_contact_phone');
        });
    }
};

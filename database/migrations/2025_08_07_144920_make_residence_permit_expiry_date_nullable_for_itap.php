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
            // Make residence permit expiry date nullable since ITAP (permanent permits) don't expire
            $table->date('residence_permit_expiry_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreigners', function (Blueprint $table) {
            // Revert back to not nullable (but this might fail if there are null values)
            $table->date('residence_permit_expiry_date')->nullable(false)->change();
        });
    }
};

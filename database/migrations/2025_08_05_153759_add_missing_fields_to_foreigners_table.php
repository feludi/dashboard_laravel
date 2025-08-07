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
            $table->date('visa_issue_date')->nullable()->after('visa_type');
            $table->string('accommodation_type')->nullable()->after('current_address');
            $table->text('purpose_of_visit')->nullable()->after('accommodation_type');
            $table->date('planned_departure_date')->nullable()->after('entry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreigners', function (Blueprint $table) {
            $table->dropColumn(['visa_issue_date', 'accommodation_type', 'purpose_of_visit', 'planned_departure_date']);
        });
    }
};

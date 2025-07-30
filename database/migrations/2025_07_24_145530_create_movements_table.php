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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foreigner_id')->constrained('foreigners')->onDelete('cascade');
            $table->decimal('from_latitude', 10, 8)->nullable();
            $table->decimal('from_longitude', 11, 8)->nullable();
            $table->string('from_location')->nullable();
            $table->decimal('to_latitude', 10, 8);
            $table->decimal('to_longitude', 11, 8);
            $table->string('to_location');
            $table->string('movement_type')->default('relocation'); // relocation, visit, temporary_stay
            $table->text('purpose')->nullable(); // Tujuan perpindahan
            $table->datetime('movement_date');
            $table->datetime('arrival_date')->nullable();
            $table->datetime('departure_date')->nullable();
            $table->string('status')->default('active'); // active, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['foreigner_id', 'movement_date']);
            $table->index(['movement_type', 'status']);
            $table->index('movement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};

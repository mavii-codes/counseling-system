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
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counseling_case_id')->constrained('counseling_cases')->cascadeOnDelete();
            $table->dateTime('session_at');
            $table->unsignedSmallInteger('duration_minutes')->default(45);
            $table->text('notes');
            $table->text('next_steps')->nullable();
            $table->timestamps();

            $table->index('session_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_sessions');
    }
};

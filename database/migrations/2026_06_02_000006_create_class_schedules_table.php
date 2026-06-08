<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('section');
            $table->string('instructor')->default('TBA');
            $table->string('room')->nullable();
            $table->string('day_of_week');
            $table->time('starts_at');
            $table->time('ends_at');
            $table->unsignedSmallInteger('capacity')->default(40);
            $table->string('school_year')->default('2025-2026');
            $table->string('semester')->default('1st Semester');
            $table->timestamps();

            $table->index(['room', 'day_of_week', 'starts_at', 'ends_at']);
            $table->index(['section', 'school_year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};

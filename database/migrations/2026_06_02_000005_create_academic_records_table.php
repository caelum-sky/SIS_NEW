<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('school_year');
            $table->string('semester');
            $table->string('year_level');
            $table->decimal('credits_attempted', 6, 2)->default(0);
            $table->decimal('credits_earned', 6, 2)->default(0);
            $table->decimal('gwa', 4, 2)->nullable();
            $table->string('status')->default('in_progress');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'school_year', 'semester'], 'student_academic_period_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};

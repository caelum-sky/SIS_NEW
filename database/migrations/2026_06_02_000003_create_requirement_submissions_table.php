<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('enrollment_year')->default('2025-2026');
            $table->string('enrollment_type')->default('first_time');
            $table->string('requirement_key');
            $table->string('title');
            $table->text('description');
            $table->string('file_path')->nullable();
            $table->string('status')->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'enrollment_year', 'requirement_key'], 'student_year_requirement_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_submissions');
    }
};

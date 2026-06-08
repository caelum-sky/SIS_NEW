<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->decimal('tf_units', 5, 2)->default(0)->after('subject_id');
            $table->decimal('lab_units', 5, 2)->default(0)->after('tf_units');
            $table->string('schedule')->default('TBA')->after('lab_units');
            $table->string('section')->nullable()->after('schedule');
            $table->string('room')->nullable()->after('section');
            $table->string('school_year')->default('2025-2026')->after('room');
            $table->string('semester')->default('1st Semester')->after('school_year');
            $table->unique(['student_id', 'subject_id', 'school_year', 'semester'], 'enrollments_student_subject_period_unique');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique('enrollments_student_subject_period_unique');
            $table->dropColumn([
                'tf_units',
                'lab_units',
                'schedule',
                'section',
                'room',
                'school_year',
                'semester',
            ]);
        });
    }
};

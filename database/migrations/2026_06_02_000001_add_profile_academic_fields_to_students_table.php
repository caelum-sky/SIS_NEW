<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unique('email');
            $table->string('student_number')->nullable()->unique()->after('id');
            $table->date('birthdate')->nullable()->after('course');
            $table->string('gender')->nullable()->after('birthdate');
            $table->string('civil_status')->default('single')->after('gender');
            $table->string('nationality')->nullable()->after('civil_status');
            $table->string('year_level')->default('1')->after('nationality');
            $table->string('section')->nullable()->after('year_level');
            $table->string('enrollment_status')->default('pending')->after('section');
            $table->string('emergency_contact_name')->nullable()->after('enrollment_status');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('guardian_name')->nullable()->after('emergency_contact_phone');
            $table->string('guardian_phone')->nullable()->after('guardian_name');
            $table->text('medical_notes')->nullable()->after('guardian_phone');
            $table->unsignedSmallInteger('credits_earned')->default(0)->after('medical_notes');
            $table->date('expected_graduation_date')->nullable()->after('credits_earned');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropUnique(['student_number']);
            $table->dropColumn([
                'student_number',
                'birthdate',
                'gender',
                'civil_status',
                'nationality',
                'year_level',
                'section',
                'enrollment_status',
                'emergency_contact_name',
                'emergency_contact_phone',
                'guardian_name',
                'guardian_phone',
                'medical_notes',
                'credits_earned',
                'expected_graduation_date',
            ]);
        });
    }
};

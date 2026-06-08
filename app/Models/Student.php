<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'student_number',
        'name',
        'email',
        'address',
        'course',
        'password',
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
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'birthdate' => 'date',
        'expected_graduation_date' => 'date',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'enrollments')
            ->withPivot(['id', 'instructor', 'grade_id', 'tf_units', 'lab_units', 'schedule', 'section', 'room', 'school_year', 'semester'])
            ->withTimestamps();
    }

    public function requirementSubmissions(): HasMany
    {
        return $this->hasMany(RequirementSubmission::class);
    }

    public function interviewSchedules(): HasMany
    {
        return $this->hasMany(InterviewSchedule::class);
    }

    public function academicRecords(): HasMany
    {
        return $this->hasMany(AcademicRecord::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function billingRecords(): HasMany
    {
        return $this->hasMany(BillingRecord::class);
    }
}

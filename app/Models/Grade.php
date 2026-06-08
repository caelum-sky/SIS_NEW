<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['grade', 'status'];

    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }

    public function student(): HasOneThrough
    {
        return $this->hasOneThrough(
            Student::class,
            Enrollment::class,
            'grade_id',
            'id',
            'id',
            'student_id'
        );
    }

    public function subject(): HasOneThrough
    {
        return $this->hasOneThrough(
            Subject::class,
            Enrollment::class,
            'grade_id',
            'id',
            'id',
            'subject_id'
        );
    }
}

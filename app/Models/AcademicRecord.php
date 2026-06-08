<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year',
        'semester',
        'year_level',
        'credits_attempted',
        'credits_earned',
        'gwa',
        'status',
        'remarks',
    ];

    protected $casts = [
        'credits_attempted' => 'decimal:2',
        'credits_earned' => 'decimal:2',
        'gwa' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

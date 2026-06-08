<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year',
        'semester',
        'tuition_amount',
        'fee_amount',
        'scholarship_amount',
        'paid_amount',
        'balance',
        'due_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'tuition_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'scholarship_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

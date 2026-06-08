<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequirementSubmission extends Model
{
    use HasFactory;

    public const REQUIREMENTS = [
        'admission_result' => [
            'title' => 'Admission Slip/Result',
            'description' => 'Photocopy of your passing result.',
        ],
        'form_138' => [
            'title' => 'Form 138 / Report Card',
            'description' => 'Original copy of your Grade 12 Report Card.',
        ],
        'good_moral' => [
            'title' => 'Good Moral Certificate',
            'description' => 'Original copy from your senior high school.',
        ],
        'birth_certificate' => [
            'title' => 'Birth Certificate',
            'description' => 'Photocopy of your PSA/NSO Birth Certificate.',
        ],
        'medical_certificate' => [
            'title' => 'Medical Certificate',
            'description' => 'Required for all incoming freshmen.',
        ],
        'id_picture' => [
            'title' => 'ID Picture',
            'description' => 'Two 2x2 ID pictures with a white background.',
        ],
        'marriage_contract' => [
            'title' => 'Additional Requirement if Married',
            'description' => 'Photocopy of Marriage Contract.',
        ],
    ];

    protected $fillable = [
        'student_id',
        'enrollment_year',
        'enrollment_type',
        'requirement_key',
        'title',
        'description',
        'file_path',
        'status',
        'remarks',
        'reviewed_by',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}

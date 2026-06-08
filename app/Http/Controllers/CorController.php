<?php

namespace App\Http\Controllers;

use App\Models\BillingRecord;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CorController extends Controller
{
    public function download(Request $request)
    {
        $student = auth('student')->user();
        $schoolYear = $request->get('school_year', '2025-2026');
        $semester = $request->get('semester', '1st Semester');

        $enrollments = Enrollment::query()
            ->where('student_id', $student->id)
            ->where('school_year', $schoolYear)
            ->where('semester', $semester)
            ->with('subject')
            ->orderBy('id')
            ->get();

        if ($enrollments->isEmpty()) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No enrollment records found for the selected school year and semester.');
        }

        $totalUnits = $enrollments->sum(fn ($e) => (float) $e->subject->units);
        $totalTf = $enrollments->sum('tf_units');
        $totalLab = $enrollments->sum('lab_units');

        $billing = BillingRecord::query()
            ->where('student_id', $student->id)
            ->where('school_year', $schoolYear)
            ->where('semester', $semester)
            ->first();

        $tuitionRate = (float) env('COR_TUITION_RATE_PER_UNIT', 350);
        $tuitionFees = $billing?->tuition_amount ?? round($totalUnits * $tuitionRate, 2);

        $defaultOtherFees = [
            'Registration' => 150.00,
            'Medical/Dental' => 200.00,
            'Athletic' => 100.00,
            'Library' => 150.00,
            'Computer/Internet' => 300.00,
            'Cultural' => 50.00,
            'Development' => 250.00,
        ];

        $otherFees = $defaultOtherFees;
        $totalOtherFees = $billing?->fee_amount ?? array_sum($otherFees);
        $totalAssessment = round((float) $tuitionFees + (float) $totalOtherFees, 2);

        $currentAssessment = $totalAssessment;
        $discounts = $billing?->scholarship_amount ?? 0;
        $previousBalance = 0;
        if ($billing) {
            $previousBalance = max(0, (float) $billing->balance - max(0, $currentAssessment - (float) $discounts));
        }
        $currentReceivable = max(0, round($currentAssessment - (float) $discounts + (float) $previousBalance, 2));

        $paymentSchedule = [
            ['due' => 'Upon Enrollment', 'amount' => round($currentReceivable * 0.5, 2)],
            ['due' => 'Midterm', 'amount' => round($currentReceivable * 0.25, 2)],
            ['due' => 'Pre-Finals', 'amount' => round($currentReceivable * 0.25, 2)],
        ];

        if ($billing?->due_date) {
            $paymentSchedule[0]['due'] = $billing->due_date->format('M d, Y');
        }

        $schoolName = env('SCHOOL_NAME', 'BUKIDNON STATE UNIVERSITY');
        $schoolLocation = env('SCHOOL_LOCATION', 'Malaybalay City, Bukidnon');

        $courseYear = trim(($student->course ?? 'N/A') . ' / Yr ' . ($student->year_level ?? '1'));
        $period = trim($semester . ' ' . $schoolYear);

        $pdf = Pdf::loadView('cor.pdf', [
            'student' => $student,
            'enrollments' => $enrollments,
            'schoolYear' => $schoolYear,
            'semester' => $semester,
            'schoolName' => $schoolName,
            'schoolLocation' => $schoolLocation,
            'courseYear' => $courseYear,
            'period' => $period,
            'corDate' => now()->format('M d, Y'),
            'totalUnits' => $totalUnits,
            'totalTf' => $totalTf,
            'totalLab' => $totalLab,
            'tuitionRate' => $tuitionRate,
            'tuitionFees' => $tuitionFees,
            'otherFees' => $otherFees,
            'totalOtherFees' => $totalOtherFees,
            'totalAssessment' => $totalAssessment,
            'currentAssessment' => $currentAssessment,
            'discounts' => $discounts,
            'previousBalance' => $previousBalance,
            'currentReceivable' => $currentReceivable,
            'paymentSchedule' => $paymentSchedule,
            'billing' => $billing,
            'generatedAt' => now(),
        ])->setPaper('letter', 'portrait');

        $filename = 'COR-' . ($student->student_number ?? $student->id) . '-' . str_replace(' ', '-', $semester) . '.pdf';

        return $pdf->download($filename);
    }
}
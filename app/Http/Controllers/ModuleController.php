<?php

namespace App\Http\Controllers;

use App\Models\AcademicRecord;
use App\Models\AttendanceRecord;
use App\Models\BillingRecord;
use App\Models\ClassSchedule;
use App\Models\Enrollment;
use App\Models\Student;

class ModuleController extends Controller
{
    public function studentProfiles()
    {
        $students = Student::query()
            ->withCount(['enrollments', 'academicRecords', 'requirementSubmissions'])
            ->orderBy('name')
            ->paginate(15);

        return view('modules.student-profiles', compact('students'));
    }

    public function showStudentProfile(Student $student)
    {
        $student->load(['academicRecords', 'enrollments.subject', 'billingRecords', 'attendanceRecords.subject']);

        return view('modules.student-profile-show', compact('student'));
    }

    public function academicHistory()
    {
        $records = AcademicRecord::with('student:id,name,student_number,course')
            ->latest()
            ->paginate(20);

        return view('modules.academic-history', compact('records'));
    }

    public function admissions()
    {
        $pendingStudents = Student::query()
            ->whereIn('enrollment_status', ['pending', 'first_time'])
            ->withCount('requirementSubmissions')
            ->orderBy('name')
            ->get();

        $recentEnrollments = Enrollment::with(['student:id,name', 'subject:id,code,name'])
            ->latest()
            ->limit(10)
            ->get();

        return view('modules.admissions', compact('pendingStudents', 'recentEnrollments'));
    }

    public function scheduling()
    {
        $schedules = ClassSchedule::with('subject')
            ->orderBy('day_of_week')
            ->orderBy('starts_at')
            ->paginate(25);

        return view('modules.scheduling', compact('schedules'));
    }

    public function attendance()
    {
        $records = AttendanceRecord::with(['student:id,name', 'subject:id,code,name', 'recorder:id,name'])
            ->latest('attendance_date')
            ->paginate(25);

        return view('modules.attendance', compact('records'));
    }

    public function billing()
    {
        $records = BillingRecord::with('student:id,name,student_number,course')
            ->latest()
            ->paginate(20);

        $summary = [
            'total_billed' => BillingRecord::sum('tuition_amount'),
            'total_paid' => BillingRecord::sum('paid_amount'),
            'total_balance' => BillingRecord::sum('balance'),
        ];

        return view('modules.billing', compact('records', 'summary'));
    }

    public function reports()
    {
        $stats = [
            'total_students' => Student::count(),
            'pending_admissions' => Student::whereIn('enrollment_status', ['pending', 'first_time'])->count(),
            'active_enrollments' => Enrollment::count(),
            'unpaid_bills' => BillingRecord::where('status', 'unpaid')->count(),
            'attendance_today' => AttendanceRecord::whereDate('attendance_date', today())->count(),
        ];

        $enrollmentByCourse = Student::query()
            ->selectRaw('course, count(*) as total')
            ->groupBy('course')
            ->orderByDesc('total')
            ->get();

        return view('modules.reports', compact('stats', 'enrollmentByCourse'));
    }
}

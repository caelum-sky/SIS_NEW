@extends('layouts.mainlayout')
@section('title', 'Dashboard')
@section('content')
<div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-4 anim-in">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Welcome back, {{ Auth::user()->name }}</h2>
        <p class="text-muted mb-0">Here's what's happening across the institution today.</p>
    </div>
</div>

@php
    $totalStudents = \App\Models\Student::count();
    $activeStudents = \App\Models\Student::whereIn('enrollment_status', ['active', 'enrolled'])->count();
    $totalSubjects = \App\Models\Subject::count();
    $activeEnrollments = \App\Models\Enrollment::count();
    $pendingRequirements = \App\Models\RequirementSubmission::where('status', 'submitted')->count();
    $teachers = \App\Models\Enrollment::whereNotNull('instructor')->distinct()->count('instructor');
    $classes = \App\Models\ClassSchedule::whereNotNull('section')->distinct()->count('section');
    $totalAttendance = \App\Models\AttendanceRecord::count();
    $presentAttendance = \App\Models\AttendanceRecord::where('status', 'present')->count();
    $attendanceRate = $totalAttendance > 0 ? round($presentAttendance / $totalAttendance * 100, 1) : null;
    $avgGrade = \App\Models\Grade::whereNotNull('grade')->whereRaw("grade ~ '^[0-9]+(\\.[0-9]+)?$'")->selectRaw('avg(grade::numeric) as v')->value('v');
    $recentStudents = \App\Models\Student::latest()->take(5)->get();
    $recentEnrollments = \App\Models\Enrollment::with(['student:id,name', 'subject:id,code,name'])->latest()->take(5)->get();
    $enrollmentByCourse = \App\Models\Student::selectRaw('course, COUNT(*) as total')->groupBy('course')->orderByDesc('total')->limit(6)->get();
    $maxCourse = max(1, (int) ($enrollmentByCourse->max('total') ?? 1));
    $gradeBuckets = ['1.0–1.5' => 0, '1.6–2.0' => 0, '2.1–3.0' => 0, '3.1+' => 0];
    foreach (\App\Models\Grade::whereNotNull('grade')->pluck('grade') as $g) {
        if (!is_numeric($g)) continue;
        $v = (float) $g;
        if ($v <= 1.5) $gradeBuckets['1.0–1.5']++;
        elseif ($v <= 2.0) $gradeBuckets['1.6–2.0']++;
        elseif ($v <= 3.0) $gradeBuckets['2.1–3.0']++;
        else $gradeBuckets['3.1+']++;
    }
    $maxBucket = max(1, max($gradeBuckets));
@endphp

<div class="row g-3 mb-4 anim-in">
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon"><i class="bi bi-people"></i></span><span class="stat-label">Students</span><span class="stat-value">{{ number_format($totalStudents) }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(34,197,94,.12);color:#4ADE80;"><i class="bi bi-person-check"></i></span><span class="stat-label">Active Students</span><span class="stat-value">{{ number_format($activeStudents) }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(6,182,212,.12);color:#22D3EE;"><i class="bi bi-person-workspace"></i></span><span class="stat-label">Teachers</span><span class="stat-value">{{ number_format($teachers) }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(168,85,247,.12);color:#C084FC;"><i class="bi bi-building"></i></span><span class="stat-label">Classes</span><span class="stat-value">{{ number_format($classes) }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(37,99,235,.12);color:#60A5FA;"><i class="bi bi-book"></i></span><span class="stat-label">Subjects</span><span class="stat-value">{{ number_format($totalSubjects) }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(245,158,11,.12);color:#FBBF24;"><i class="bi bi-check2-square"></i></span><span class="stat-label">Attendance Rate</span><span class="stat-value">{{ $attendanceRate !== null ? $attendanceRate . '%' : '—' }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(239,68,68,.12);color:#F87171;"><i class="bi bi-hourglass-split"></i></span><span class="stat-label">Pending Requirements</span><span class="stat-value">{{ number_format($pendingRequirements) }}</span></div></div>
    <div class="col-6 col-lg-3"><div class="card stat-card hover-lift h-100"><span class="stat-icon" style="background:rgba(34,197,94,.12);color:#4ADE80;"><i class="bi bi-graph-up"></i></span><span class="stat-label">Average Grade</span><span class="stat-value">{{ $avgGrade !== null ? number_format($avgGrade, 2) : '—' }}</span></div></div>
</div>

<div class="row g-3 mb-4 anim-in">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">Enrollment by Course</div>
            <div class="card-body">
                @forelse($enrollmentByCourse as $row)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1"><span style="color:var(--text-2);">{{ $row->course ?: 'Unspecified' }}</span><span style="color:var(--text-3);">{{ $row->total }}</span></div>
                        <div style="height:8px;border-radius:999px;background:rgba(148,163,184,.12);">
                            <div style="height:100%;width:{{ round($row->total / $maxCourse * 100) }}%;border-radius:999px;background:linear-gradient(90deg,#2563EB,#22D3EE);"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No enrollment data yet.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">Grade Performance Distribution</div>
            <div class="card-body">
                @foreach($gradeBuckets as $label => $count)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1"><span style="color:var(--text-2);">{{ $label }}</span><span style="color:var(--text-3);">{{ $count }}</span></div>
                        <div style="height:8px;border-radius:999px;background:rgba(148,163,184,.12);">
                            <div style="height:100%;width:{{ round($count / $maxBucket * 100) }}%;border-radius:999px;background:linear-gradient(90deg,#059669,#22C55E);"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row g-3 anim-in">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">Recent Students</div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table mb-0">
                        <thead><tr><th>Name</th><th>Email</th><th>Course</th></tr></thead>
                        <tbody>
                            @forelse($recentStudents as $s)
                                <tr>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->email }}</td>
                                    <td>{{ $s->course ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">No students yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">Recent Activity</div>
            <div class="card-body">
                @forelse($recentEnrollments as $e)
                    <div class="d-flex gap-2 mb-3">
                        <span class="stat-icon" style="width:32px;height:32px;font-size:.9rem;margin:0;"><i class="bi bi-journal-plus"></i></span>
                        <div>
                            <div style="color:var(--text-1);font-size:.88rem;font-weight:600;">{{ $e->student->name ?? 'Student' }}</div>
                            <div style="color:var(--text-3);font-size:.8rem;">Enrolled in {{ $e->subject->code ?? '—' }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No recent activity.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

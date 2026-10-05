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
    $totalSubjects = \App\Models\Subject::count();
    $activeEnrollments = \App\Models\Enrollment::count();
    $pendingRequirements = \App\Models\RequirementSubmission::where('status', 'submitted')->count();
    $recentStudents = \App\Models\Student::latest()->take(5)->get();
@endphp

<div class="row g-3 mb-4 anim-in">
    <div class="col-6 col-lg-3">
        <div class="card stat-card hover-lift h-100">
            <span class="stat-icon"><i class="bi bi-people"></i></span>
            <span class="stat-label">Students</span>
            <span class="stat-value">{{ number_format($totalStudents) }}</span>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card hover-lift h-100">
            <span class="stat-icon" style="background:rgba(6,182,212,.12);color:#22D3EE;"><i class="bi bi-book"></i></span>
            <span class="stat-label">Subjects</span>
            <span class="stat-value">{{ number_format($totalSubjects) }}</span>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card hover-lift h-100">
            <span class="stat-icon" style="background:rgba(34,197,94,.12);color:#4ADE80;"><i class="bi bi-collection"></i></span>
            <span class="stat-label">Enrollments</span>
            <span class="stat-value">{{ number_format($activeEnrollments) }}</span>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card hover-lift h-100">
            <span class="stat-icon" style="background:rgba(245,158,11,.12);color:#FBBF24;"><i class="bi bi-hourglass-split"></i></span>
            <span class="stat-label">Pending Requirements</span>
            <span class="stat-value">{{ number_format($pendingRequirements) }}</span>
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
            <div class="card-header">Quick Actions</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('interviews.index') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-calendar-event me-2"></i>Interview Calendar</a>
                <a href="{{ route('admin.requirements.index') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-file-earmark-check me-2"></i>Requirements Review</a>
                <a href="{{ route('modules.reports') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-bar-chart me-2"></i>Reports &amp; Analytics</a>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-people me-2"></i>Manage Students</a>
            </div>
        </div>
    </div>
</div>
@endsection

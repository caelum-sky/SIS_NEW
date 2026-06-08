@extends('layouts.mainlayout')
@section('title', 'Reports & Analytics')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Reporting & Analytics Dashboard</h3>
        <div class="row g-3 mb-4">
            @foreach([
                ['Total Students', $stats['total_students']],
                ['Pending Admissions', $stats['pending_admissions']],
                ['Active Enrollments', $stats['active_enrollments']],
                ['Unpaid Bills', $stats['unpaid_bills']],
                ['Attendance Today', $stats['attendance_today']],
            ] as [$label, $value])
                <div class="col-md">
                    <div class="card text-center p-3 shadow-sm">
                        <div class="text-muted small">{{ $label }}</div>
                        <div class="fs-3 fw-bold">{{ $value }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Enrollment by Course (Forecasting & Retention)</div>
            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Course</th><th>Students</th></tr></thead>
                    <tbody>
                        @forelse($enrollmentByCourse as $row)
                            <tr><td>{{ $row->course ?: 'Unspecified' }}</td><td>{{ $row->total }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-muted">No data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

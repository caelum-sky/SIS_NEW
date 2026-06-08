@extends('layouts.mainlayout')
@section('title', 'Admissions & Enrollment')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Admissions & Enrollment Tracking</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header fw-bold">Pending / First-time Applicants</div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm">
                            <thead><tr><th>Name</th><th>Course</th><th>Requirements</th></tr></thead>
                            <tbody>
                                @forelse($pendingStudents as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->course }}</td>
                                        <td>{{ $student->requirement_submissions_count }} submitted</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-muted">No pending applicants.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header fw-bold">Recent Registrations</div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm">
                            <thead><tr><th>Student</th><th>Subject</th></tr></thead>
                            <tbody>
                                @forelse($recentEnrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->student->name }}</td>
                                        <td>{{ $enrollment->subject->code }} — {{ $enrollment->subject->name }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-muted">No recent enrollments.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

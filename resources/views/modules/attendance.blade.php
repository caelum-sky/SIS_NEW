@extends('layouts.mainlayout')
@section('title', 'Attendance')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Attendance Management</h3>
        <p class="text-muted mb-3">Teachers log daily attendance, tardiness, and absences per subject.</p>
        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Date</th><th>Student</th><th>Subject</th><th>Status</th><th>Recorded By</th><th>Remarks</th></tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->attendance_date->format('M d, Y') }}</td>
                            <td>{{ $record->student->name }}</td>
                            <td>{{ $record->subject?->code ?? 'General' }}</td>
                            <td><span class="badge bg-{{ $record->status === 'present' ? 'success' : ($record->status === 'late' ? 'warning' : 'danger') }}">{{ ucfirst($record->status) }}</span></td>
                            <td>{{ $record->recorder?->name ?? '—' }}</td>
                            <td>{{ $record->remarks ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No attendance records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $records->links() }}</div>
    </div>
</div>
@endsection

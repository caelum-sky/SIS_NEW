@extends('layouts.mainlayout')
@section('title', 'Class Scheduling')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Class Timetables & Room Assignments</h3>
        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Subject</th><th>Section</th><th>Day</th><th>Time</th><th>Room</th><th>Instructor</th><th>Capacity</th><th>SY / Sem</th></tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->subject->code }} — {{ $schedule->subject->name }}</td>
                            <td>{{ $schedule->section }}</td>
                            <td>{{ $schedule->day_of_week }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->starts_at)->format('g:i A') }} – {{ \Carbon\Carbon::parse($schedule->ends_at)->format('g:i A') }}</td>
                            <td>{{ $schedule->room ?? 'TBA' }}</td>
                            <td>{{ $schedule->instructor }}</td>
                            <td>{{ $schedule->capacity }}</td>
                            <td>{{ $schedule->school_year }} / {{ $schedule->semester }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No class schedules defined. Room conflict resolution will apply when schedules overlap.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $schedules->links() }}</div>
    </div>
</div>
@endsection

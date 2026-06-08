@extends('layouts.mainlayout')
@section('title', 'Academic History')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Academic History & Transcripts</h3>
        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Student</th><th>School Year</th><th>Semester</th><th>Year Level</th><th>Credits</th><th>GWA</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->student->name }}</td>
                            <td>{{ $record->school_year }}</td>
                            <td>{{ $record->semester }}</td>
                            <td>{{ $record->year_level }}</td>
                            <td>{{ $record->credits_earned }}/{{ $record->credits_attempted }}</td>
                            <td>{{ $record->gwa ?? '—' }}</td>
                            <td>{{ $record->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No records yet. Academic periods are tracked here for transcripts and graduation.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $records->links() }}</div>
    </div>
</div>
@endsection

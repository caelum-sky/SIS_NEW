@extends('layouts.mainlayout')
@section('title', 'Student Profile')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white fw-bold m-0">{{ $student->name }}</h3>
            <a href="{{ route('modules.students.index') }}" class="btn btn-outline-light btn-sm">Back</a>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Personal & Demographic</div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Address:</strong> {{ $student->address }}</p>
                        <p><strong>Birthdate:</strong> {{ $student->birthdate?->format('M d, Y') ?? '—' }}</p>
                        <p><strong>Gender:</strong> {{ $student->gender ?? '—' }}</p>
                        <p><strong>Nationality:</strong> {{ $student->nationality ?? '—' }}</p>
                        <p><strong>Civil Status:</strong> {{ $student->civil_status }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Emergency & Medical</div>
                    <div class="card-body">
                        <p><strong>Emergency Contact:</strong> {{ $student->emergency_contact_name ?? '—' }} ({{ $student->emergency_contact_phone ?? '—' }})</p>
                        <p><strong>Guardian:</strong> {{ $student->guardian_name ?? '—' }} ({{ $student->guardian_phone ?? '—' }})</p>
                        <p><strong>Medical Notes:</strong> {{ $student->medical_notes ?? 'None' }}</p>
                        <p><strong>Credits Earned:</strong> {{ $student->credits_earned }}</p>
                        <p><strong>Expected Graduation:</strong> {{ $student->expected_graduation_date?->format('M d, Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Academic History</div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm">
                            <thead><tr><th>SY</th><th>Sem</th><th>Year Level</th><th>GWA</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($student->academicRecords as $record)
                                    <tr>
                                        <td>{{ $record->school_year }}</td>
                                        <td>{{ $record->semester }}</td>
                                        <td>{{ $record->year_level }}</td>
                                        <td>{{ $record->gwa ?? '—' }}</td>
                                        <td>{{ $record->status }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-muted">No academic records.</td></tr>
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

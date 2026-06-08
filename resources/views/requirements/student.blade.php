@extends('layouts.studentlayout')
@section('title', 'Enrollment Requirements')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-4">
            <h3 class="text-light fw-bold">Enrollment Requirements Submission</h3>
            <p class="text-muted">Submit documents to enroll for the first time or for the following school year.</p>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">School Year</label>
                        <input type="text" name="enrollment_year" class="form-control" value="{{ $enrollmentYear }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Enrollment Type</label>
                        <select name="enrollment_type" class="form-select">
                            <option value="first_time" @selected($enrollmentType === 'first_time')>First-time Enrollee</option>
                            <option value="continuing" @selected($enrollmentType === 'continuing')>Continuing / Next Year</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @foreach($requirements as $key => $requirement)
                @php $submission = $submissions->get($key); @endphp
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $requirement['title'] }}</strong>
                            @if($submission)
                                <span class="badge bg-{{ $submission->status === 'approved' ? 'success' : ($submission->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Not submitted</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <p class="text-muted small">{{ $requirement['description'] }}</p>
                            @if($key === 'marriage_contract' && $student->civil_status !== 'married')
                                <p class="text-info small">Only required if married.</p>
                            @endif
                            @if($submission?->remarks)
                                <p class="small text-danger">Remarks: {{ $submission->remarks }}</p>
                            @endif
                            <form method="POST" action="{{ route('student.requirements.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="requirement_key" value="{{ $key }}">
                                <input type="hidden" name="enrollment_year" value="{{ $enrollmentYear }}">
                                <input type="hidden" name="enrollment_type" value="{{ $enrollmentType }}">
                                <div class="mb-2">
                                    <input type="file" name="document" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png" required>
                                </div>
                                <button class="btn btn-sm btn-success">
                                    {{ $submission ? 'Re-upload' : 'Submit' }}
                                </button>
                                @if($submission?->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

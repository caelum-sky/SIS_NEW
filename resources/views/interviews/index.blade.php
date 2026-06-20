@extends('layouts.mainlayout')
@section('title', 'Interview Calendar')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h3 class="text-white fw-bold m-0">Interview Scheduling Calendar</h3>
                <small class="text-white-50">First-year and first-time enrollee interview slots</small>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#interviewModal" id="addInterviewBtn">
                <i class="bi bi-calendar-plus"></i> Schedule Interview
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('interviews.index', ['month' => $previousMonth]) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <strong>{{ $month->format('F Y') }}</strong>
                <a href="{{ route('interviews.index', ['month' => $nextMonth]) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="sis-calendar">
                    <div class="sis-calendar-head">Mon</div>
                    <div class="sis-calendar-head">Tue</div>
                    <div class="sis-calendar-head">Wed</div>
                    <div class="sis-calendar-head">Thu</div>
                    <div class="sis-calendar-head">Fri</div>
                    <div class="sis-calendar-head">Sat</div>
                    <div class="sis-calendar-head">Sun</div>

                    @foreach($weeks as $week)
                        @foreach($week as $day)
                            @php
                                $dayInterviews = $interviews->get($day->toDateString(), collect());
                            @endphp
                            <div class="sis-calendar-day {{ $day->isSameMonth($month) ? '' : 'is-muted' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>{{ $day->format('j') }}</strong>
                                    @if($day->isToday())
                                        <span class="badge bg-primary">Today</span>
                                    @endif
                                </div>
                                <div class="d-grid gap-1">
                                    @foreach($dayInterviews as $interview)
                                        <button
                                            type="button"
                                            class="btn btn-sm text-start btn-outline-primary interview-event"
                                            data-id="{{ $interview->id }}"
                                            data-student-id="{{ $interview->student_id }}"
                                            data-title="{{ $interview->title }}"
                                            data-starts-at="{{ $interview->starts_at->format('Y-m-d\TH:i') }}"
                                            data-ends-at="{{ $interview->ends_at->format('Y-m-d\TH:i') }}"
                                            data-mode="{{ $interview->mode }}"
                                            data-status="{{ $interview->status }}"
                                            data-location="{{ $interview->location }}"
                                            data-notes="{{ $interview->notes }}"
                                        >
                                            <span class="fw-semibold">{{ $interview->starts_at->format('g:i A') }}</span>
                                            {{ $interview->student?->name ?? 'Student' }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="interviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="interviewForm" method="POST" action="{{ route('interviews.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="PUT" disabled>
                <div class="modal-header">
                    <h5 class="modal-title" id="interviewModalTitle">Schedule Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">Select first-year / first-time student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} - {{ $student->course }} (Yr {{ $student->year_level }}, {{ $student->enrollment_status }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="Enrollment Interview" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start</label>
                            <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End</label>
                            <input type="datetime-local" name="ends_at" id="ends_at" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mode</label>
                            <select name="mode" id="mode" class="form-select" required>
                                <option value="on-site">On-site</option>
                                <option value="online">Online</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="rescheduled">Rescheduled</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location / Meeting Link</label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Admissions Office or meeting link">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger d-none" id="deleteInterviewBtn">Delete</button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
            <form id="deleteForm" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('interviewModal');
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById('interviewForm');
    const methodInput = document.getElementById('formMethod');
    const deleteBtn = document.getElementById('deleteInterviewBtn');
    const deleteForm = document.getElementById('deleteForm');

    document.getElementById('addInterviewBtn').addEventListener('click', resetForm);

    document.querySelectorAll('.interview-event').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.id;
            document.getElementById('interviewModalTitle').textContent = 'Edit Interview';
            form.action = '/admin/interviews/' + id;
            methodInput.disabled = false;
            document.getElementById('student_id').value = button.dataset.studentId || '';
            document.getElementById('title').value = button.dataset.title || 'Enrollment Interview';
            document.getElementById('starts_at').value = button.dataset.startsAt || '';
            document.getElementById('ends_at').value = button.dataset.endsAt || '';
            document.getElementById('mode').value = button.dataset.mode || 'on-site';
            document.getElementById('status').value = button.dataset.status || 'scheduled';
            document.getElementById('location').value = button.dataset.location || '';
            document.getElementById('notes').value = button.dataset.notes || '';
            deleteBtn.classList.remove('d-none');
            deleteForm.action = '/admin/interviews/' + id;
            modal.show();
        });
    });

    deleteBtn.addEventListener('click', function () {
        if (window.confirm('Delete this interview schedule?')) {
            deleteForm.submit();
        }
    });

    function resetForm() {
        form.action = '{{ route('interviews.store') }}';
        form.reset();
        methodInput.disabled = true;
        document.getElementById('interviewModalTitle').textContent = 'Schedule Interview';
        document.getElementById('title').value = 'Enrollment Interview';
        deleteBtn.classList.add('d-none');
    }
});
</script>
@endpush

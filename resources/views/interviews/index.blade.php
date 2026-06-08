@extends('layouts.mainlayout')
@section('title', 'Interview Calendar')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white fw-bold m-0">Interview Scheduling Calendar</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#interviewModal" id="addInterviewBtn">
                <i class="bi bi-calendar-plus"></i> Schedule Interview
            </button>
        </div>

        <div class="card shadow-sm p-3 bg-white rounded-3">
            <div id="interviewCalendar"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="interviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="interviewForm" method="POST" action="{{ route('interviews.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="interviewModalTitle">Schedule Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Student (First-year / First-time)</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">Select student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} — {{ $student->course }} (Yr {{ $student->year_level }}, {{ $student->enrollment_status }})
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
                        <input type="text" name="location" id="location" class="form-control" placeholder="Room 101 or Zoom link">
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

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('interviewCalendar');
    const modal = new bootstrap.Modal(document.getElementById('interviewModal'));
    const form = document.getElementById('interviewForm');
    const deleteForm = document.getElementById('deleteForm');
    const deleteBtn = document.getElementById('deleteInterviewBtn');
    let editingId = null;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '{{ route('interviews.events') }}',
        eventClick: function (info) {
            editingId = info.event.id;
            const props = info.event.extendedProps;
            document.getElementById('interviewModalTitle').textContent = 'Edit Interview';
            document.getElementById('formMethod').value = 'PUT';
            form.action = `/admin/interviews/${editingId}`;
            document.getElementById('student_id').value = props.student_id || '';
            document.getElementById('title').value = info.event.title;
            document.getElementById('starts_at').value = info.event.startStr.slice(0, 16);
            document.getElementById('ends_at').value = info.event.end ? info.event.endStr.slice(0, 16) : '';
            document.getElementById('mode').value = props.mode || 'on-site';
            document.getElementById('status').value = props.status || 'scheduled';
            document.getElementById('location').value = props.location || '';
            document.getElementById('notes').value = props.notes || '';
            deleteBtn.classList.remove('d-none');
            deleteForm.action = `/admin/interviews/${editingId}`;
            modal.show();
        },
        dateClick: function (info) {
            resetForm();
            document.getElementById('starts_at').value = info.dateStr + 'T09:00';
            document.getElementById('ends_at').value = info.dateStr + 'T10:00';
            modal.show();
        }
    });
    calendar.render();

    document.getElementById('addInterviewBtn').addEventListener('click', resetForm);

    deleteBtn.addEventListener('click', function () {
        if (confirm('Delete this interview?')) {
            deleteForm.submit();
        }
    });

    function resetForm() {
        editingId = null;
        document.getElementById('interviewModalTitle').textContent = 'Schedule Interview';
        document.getElementById('formMethod').value = 'POST';
        form.action = '{{ route('interviews.store') }}';
        form.reset();
        document.getElementById('title').value = 'Enrollment Interview';
        deleteBtn.classList.add('d-none');
    }
});
</script>
@endsection

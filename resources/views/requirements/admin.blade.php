@extends('layouts.mainlayout')
@section('title', 'Requirement Reviews')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h3 class="text-white fw-bold mb-4">Enrollment Requirement Submissions</h3>

        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Requirement</th>
                        <th>Year / Type</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td>
                                <strong>{{ $submission->student->name }}</strong><br>
                                <small class="text-muted">{{ $submission->student->email }}</small>
                            </td>
                            <td>{{ $submission->title }}</td>
                            <td>{{ $submission->enrollment_year }}<br><small>{{ ucfirst(str_replace('_', ' ', $submission->enrollment_type)) }}</small></td>
                            <td><span class="badge bg-secondary">{{ ucfirst($submission->status) }}</span></td>
                            <td>{{ $submission->submitted_at?->format('M d, Y') ?? '—' }}</td>
                            <td>
                                @if($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                @endif
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $submission->id }}">Review</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="reviewModal{{ $submission->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.requirements.review', $submission) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Review: {{ $submission->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                    <option value="needs_revision">Needs Revision</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Remarks</label>
                                                <textarea name="remarks" class="form-control" rows="3">{{ $submission->remarks }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save Review</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No submissions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $submissions->links() }}</div>
    </div>
</div>
@endsection

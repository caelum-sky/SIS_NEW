@extends('layouts.mainlayout')
@section('title', 'Student Profiles')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Centralized Student Database</h3>
        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student #</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Enrollments</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->student_number ?? '—' }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->course }}</td>
                            <td>{{ $student->year_level }}</td>
                            <td>{{ $student->enrollment_status }}</td>
                            <td>{{ $student->enrollments_count }}</td>
                            <td><a href="{{ route('modules.students.show', $student) }}" class="btn btn-sm btn-primary">View Profile</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $students->links() }}</div>
    </div>
</div>
@endsection

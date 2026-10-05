@extends('layouts.mainlayout')
@section('title', 'Student List')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 anim-in">
    <div>
        <h3 class="fw-bold text-white m-0">Students</h3>
        <small class="text-muted">Manage the student registry.</small>
    </div>
    <button
        type="button"
        class="btn btn-success d-flex align-items-center gap-2"
        data-bs-toggle="modal"
        data-bs-target="#triggerModal"
        data-id=""
        data-name=""
        data-email=""
        data-action="{{ route('students.store') }}"
        data-method="POST"
        data-mode="add">
        <i class="bi bi-plus-lg"></i> Add Student
    </button>
</div>

<div class="table-responsive anim-in">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Course</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($studentList as $students)
            <tr data-bs-toggle="modal"
                data-bs-target="#triggerModalStudentInformation"
                data-id="{{$students->id}}"
                data-name="{{$students->name}}"
                data-email="{{$students->email}}"
                data-course="{{$students->course}}">
                <td>{{ $students->id }}</td>
                <td>{{ $students->name }}</td>
                <td>{{ $students->email }}</td>
                <td>{{ $students->address }}</td>
                <td>{{ $students->course }}</td>
                <td class="d-flex gap-3">
                    <a href="#"
                        class="text-success"
                        aria-label="Edit"
                        data-bs-toggle="modal"
                        data-bs-target="#triggerModal"
                        data-id="{{ $students->id }}"
                        data-name="{{ $students->name }}"
                        data-email="{{ $students->email }}"
                        data-address="{{ $students->address }}"
                        data-course="{{ $students->course }}"
                        data-mode="edit"
                        data-action="{{ route('students.update', $students->id) }}"
                        data-method="PUT"
                        onclick="highlightRow(this)">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <a href="#"
                        class="text-primary"
                        aria-label="Info"
                        data-bs-toggle="modal"
                        data-bs-target="#triggerModalInformation"
                        data-id="{{ $students->id }}"
                        onclick="highlightRow(this)">
                        <i class="bi bi-info-circle"></i>
                    </a>

                    <a href="#"
                        class="text-danger"
                        aria-label="Delete"
                        onclick="deleteStudent('{{ $students->id }}'); highlightRow(this);">
                        <i class="bi bi-trash"></i>
                    </a>

                    <form action="{{route('students.destroy', $students->id)}}"
                          id="IdToDelete-{{$students->id}}"
                          method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function highlightRow(element) {
        document.querySelectorAll('tbody tr').forEach(row => row.classList.remove('table-active'));
        element.closest('tr').classList.add('table-active');
    }
</script>

@if(\Session::has('success'))
<script>
    Swal.fire({ title: "Success", text: "{{\Session::get('success')}}", icon: "success" });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({ title: "Validation Error", html: @json(implode('<br>', $errors->all())), icon: "error", confirmButtonText: "OK" });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({ title: "Something went wrong", text: "{{ session('error') }}", icon: "error", confirmButtonText: "OK" });
</script>
@endif

<script>
    function deleteStudent(id) {
        Swal.fire({
            title: "Delete",
            text: "Are you sure you want to delete this student?",
            icon: "warning",
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("IdToDelete-" + id).submit();
            }
        });
    }
</script>

<script src="{{ asset('assets/js/studentModalHandler.js') }}" defer></script>
<script src="{{ asset('assets/js/enrollmentModalHandler.js') }}" defer></script>
<script src="{{ asset('assets/js/studentInfoModalHandler.js') }}" defer></script>
@include('modals.studentModal')
@include('modals.enrollmentModal')
@include('modals.studentInfoModal')
@endsection

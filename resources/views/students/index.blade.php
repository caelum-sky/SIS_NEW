@extends('layouts.mainlayout')
@section('title', 'Student List')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h3 class="welcome-text text-white fw-bold m-0">Student Table</h3>
                    <button 
                        type="button" 
                        class="btn btn-success d-flex align-items-center gap-2 shadow-sm"
                        data-bs-toggle="modal" 
                        data-bs-target="#triggerModal"
                        data-id="" 
                        data-name="" 
                        data-email="" 
                        data-action="{{ route('students.store') }}" 
                        data-method="POST" 
                        data-mode="add">
                        ➕
                        Add Student
                    </button>
                </div>

                <div class="table-responsive rounded-3 shadow-sm bg-white" style="height: calc(100vh - 210px); overflow-y: auto;">
                    <table class="table table-hover table-bordered">
                        <thead class="table-white text-white">
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
                            @foreach($studentList as $students)
                            <tr class="align-middle" 
                                data-bs-toggle="modal" 
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
                                        class="text-success fs-4" 
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
                                        ✏️
                                    </a>
                                    
                                    <a href="#" 
                                        class="text-primary fs-4" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#triggerModalInformation" 
                                        data-id="{{ $students->id }}"
                                        onclick="highlightRow(this)">
                                        📝
                                    </a>
                                    
                                    <a href="#" 
                                        class="text-danger fs-4"
                                        onclick="deleteStudent('{{ $students->id }}'); highlightRow(this);">
                                        🗑️
                                    </a>

                                    <form action="{{route('students.destroy', $students->id)}}" 
                                          id="IdToDelete-{{$students->id}}" 
                                          method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function highlightRow(element) {
        document.querySelectorAll('tbody tr').forEach(row => row.classList.remove('table-active'));
        element.closest('tr').classList.add('table-active');
    }
</script>

@if(\Session::has('success'))
<script>
    Swal.fire({
        title: "Success",
        text: "{{\Session::get('success')}}",
        icon: "success",
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        title: "Validation Error",
        html: "{!! implode('<br>', $errors->all()) !!}",
        icon: "error",
        confirmButtonText: "OK"
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: "Something went wrong",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonText: "OK"
    });
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
                const form = document.getElementById("IdToDelete-" + id)
                form.submit();
            }
        });
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/studentModalHandler.js"></script>
<script src="assets/js/enrollmentModalHandler.js"></script>
<script src="assets/js/studentInfoModalHandler.js"></script>
@include('modals.studentModal')
@include('modals.enrollmentModal')
@include('modals.studentInfoModal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

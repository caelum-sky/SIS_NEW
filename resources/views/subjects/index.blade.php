@extends('layouts.mainlayout')
@section('title', 'Subject List')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h3 class="welcome-text text-white fw-bold m-0">Subject Table</h3>
                    <button type="button" 
                        class="btn btn-success d-flex align-items-center gap-2 shadow-sm"
                        data-bs-toggle="modal" 
                        data-bs-target="#triggerModalSubject"
                        data-id="" 
                        data-name="" 
                        data-code="" 
                        data-units="" 
                        data-action="{{ route('subjects.store') }}" 
                        data-method="POST" 
                        data-mode="add">
                        ➕
                        Add Subject
                    </button>
                </div>

                <div class="table-responsive rounded-3 shadow-sm bg-white" 
                     style="height: calc(100vh - 210px); overflow-y: auto;">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light text-white">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Subject Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Units</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjectList as $subjects)
                            <tr class="align-middle">
                                <td>{{ $subjects->id }}</td>
                                <td>{{ $subjects->code }}</td>
                                <td>{{ $subjects->name }}</td>
                                <td>{{ $subjects->units }}</td>
                                <td class="d-flex gap-3">
                                    <a href="#" 
                                        class="text-success fs-4" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#triggerModalSubject" 
                                        data-id="{{ $subjects->id }}"
                                        data-name="{{ $subjects->name }}" 
                                        data-code="{{ $subjects->code }}" 
                                        data-units="{{ $subjects->units }}" 
                                        data-mode="edit"
                                        data-action="{{ route('subjects.update', $subjects->id) }}" 
                                        data-method="PUT">
                                        ✏️
                                    </a>
                                    
                                    <a href="#" 
                                        class="text-danger fs-4"
                                        onclick="deleteSubject('{{ $subjects->id }}')">
                                        🗑️
                                    </a>

                                    <form action="{{route('subjects.destroy', $subjects->id)}}" 
                                          id="IdToDelete-{{$subjects->id}}" 
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

@if(\Session::has('success'))
<script>
    Swal.fire({
        title: "Success",
        text: "{{\Session::get('success')}}",
        icon: "success",
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

<script>
    function deleteSubject(id) {
        Swal.fire({
            title: "Delete Subject",
            text: "Are you sure you want to delete this subject?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("IdToDelete-" + id);
                form.submit();
            }
        });
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/subjectModalHandler.js"></script>
@include('modals.subjectModal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

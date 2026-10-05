@extends('layouts.mainlayout')
@section('title', 'Subject List')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 anim-in">
    <div>
        <h3 class="fw-bold text-white m-0">Subjects</h3>
        <small class="text-muted">Curriculum subjects and units.</small>
    </div>
    <button type="button"
        class="btn btn-success d-flex align-items-center gap-2"
        data-bs-toggle="modal"
        data-bs-target="#triggerModalSubject"
        data-id=""
        data-name=""
        data-code=""
        data-units=""
        data-action="{{ route('subjects.store') }}"
        data-method="POST"
        data-mode="add">
        <i class="bi bi-plus-lg"></i> Add Subject
    </button>
</div>

<div class="table-responsive anim-in">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Subject Code</th>
                <th scope="col">Name</th>
                <th scope="col">Units</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjectList as $subjects)
            <tr>
                <td>{{ $subjects->id }}</td>
                <td>{{ $subjects->code }}</td>
                <td>{{ $subjects->name }}</td>
                <td>{{ $subjects->units }}</td>
                <td class="d-flex gap-3">
                    <a href="#"
                        class="text-success"
                        aria-label="Edit"
                        data-bs-toggle="modal"
                        data-bs-target="#triggerModalSubject"
                        data-id="{{ $subjects->id }}"
                        data-name="{{ $subjects->name }}"
                        data-code="{{ $subjects->code }}"
                        data-units="{{ $subjects->units }}"
                        data-mode="edit"
                        data-action="{{ route('subjects.update', $subjects->id) }}"
                        data-method="PUT">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <a href="#"
                        class="text-danger"
                        aria-label="Delete"
                        onclick="deleteSubject('{{ $subjects->id }}')">
                        <i class="bi bi-trash"></i>
                    </a>

                    <form action="{{route('subjects.destroy', $subjects->id)}}"
                          id="IdToDelete-{{$subjects->id}}"
                          method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No subjects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(\Session::has('success'))
<script>Swal.fire({ title: "Success", text: "{{\Session::get('success')}}", icon: "success" });</script>
@endif

@if (session('error'))
<script>Swal.fire({ title: "Something went wrong", text: "{{ session('error') }}", icon: "error", confirmButtonText: "OK" });</script>
@endif

@if ($errors->any())
<script>Swal.fire({ title: "Validation Error", html: @json(implode('<br>', $errors->all())), icon: "error", confirmButtonText: "OK" });</script>
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
                document.getElementById("IdToDelete-" + id).submit();
            }
        });
    }
</script>

<script src="{{ asset('assets/js/subjectModalHandler.js') }}" defer></script>
@include('modals.subjectModal')
@endsection

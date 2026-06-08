<div class="modal fade" id="triggerModalStudentInformation" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold fs-5" id="modalTitle">Student Enrollment Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <div id="informationCOntainer" class="d-flex gap-5 p-2 mb-3 rounded-3 border bg-white">
                    <div>
                        <p class="fw-bold mb-1">ID: <span id="student_id" class="fw-normal ms-2"></span></p>
                        <p class="fw-bold mb-1">Name: <span id="student_name" class="fw-normal ms-2"> </span></p>
                    </div>
                    <div>
                        <p class="fw-bold mb-1">Email: <span id="email" class="fw-normal ms-2"></span></p>
                        <p class="fw-bold mb-1">Course: <span id="student_address" class="fw-normal ms-2"> </span></p>
                    </div>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#triggerGradesModal" type="btn">View Grades</button>
                    </div>
                </div>
                <div class="border rounded-3 bg-white p-3" style="max-height: 500px; overflow-y:scroll; scrollbar-width:none">
                    <table class="table table-striped">
                        <colGroup>
                            <col width="10%">
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width="10%">
                        </colGroup>
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Subject code</th>
                                <th>Subject name</th>
                                <th>Units</th>
                                <th>Instructor</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody id="enrollmentList">

                        </tbody>
                    </table>
                    <form action="" id="IdToDelete" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/gradesModalHandler.js"></script>
<script src="assets/js/editEnrollmentHandler.js"></script>

<script>
    function deleteSubject(id) {
        console.log(id);
        Swal.fire({
            title: "Delete",
            text: "Are you sure you want to remove this subject for this student?",
            icon: "warning",
            showCancelButton: true,

        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("IdToDelete");
                form.action = `/student/enroll/${id}`
                console.log(form.action);
                form.submit();
            }
        });

    }
</script>
@include('modals.gradesModal')
@include('modals.editEnrollment')
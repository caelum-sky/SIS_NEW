<div class="modal fade" id="triggerEditEnrollment" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" id="thisModal">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold fs-5" id="gradeModalTitle">Edit Enrollment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <form action="" method="POST" id="editEnrollmentForm">
                    @csrf
                    <input hidden class="form-control" name="enrollment_id" id="enrollment_id" placeholder="123">
                    <div class="form-floating mb-3">
                        <input type="num" class="form-control" disabled name="subject_code" id="subjectCode1" placeholder="123">
                        <label for="subjectCode">Subject Code</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="num" class="form-control" disabled name="subjectName" id="subjectName1" placeholder="123">
                        <label for="subjectName">Subject Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="instructor" id="instructor" placeholder="Enter Name">
                        <label for="instructor">Instructor</label>
                    </div>
                    <button type="submit" class="btn btn-success fw-bold" id="submitButton" style="width: 100%;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

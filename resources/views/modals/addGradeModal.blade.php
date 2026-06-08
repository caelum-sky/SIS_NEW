<div class="modal fade" id="triggerAddGradeModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" id="thisModal">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold fs-5" id="gradeModalTitle">Add Grade</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-white p-4">
                <form action="" method="POST" id="gradeForm">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" name="studentId" id="studentIdGrade" placeholder="123">
                        <label for="studentId">Student ID</label>
                    </div>
                    <input hidden class="form-control" name="enrollment_id" id="enrollment_id">
                    <input hidden class="form-control" name="grade_id" id="grade_id">
                    <div class="form-floating mb-3">
                        <input type="num" class="form-control" name="subject_code" id="sCode" placeholder="123">
                        <label for="sCode">Subject Code</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="grade" id="grade">
                            @for ($grade = 1.0; $grade <= 5.0; $grade += 0.25)
                                <option value="{{ number_format($grade, 2) }}">{{ number_format($grade, 2) }}</option>
                            @endfor
                            <option value="INC">INC</option>
                            <option value="FDA">FDA</option>
                        </select>
                        <label for="grade">Grade</label>
                    </div>
                    <button type="submit" class="btn btn-success fw-bold" id="submitButton" style="width: 100%;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

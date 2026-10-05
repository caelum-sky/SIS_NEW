<div class="modal fade" id="triggerModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold fs-5" id="modalTitle">Student Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <form action="" method="" id="studentForm">
                    @csrf
                    <div class="form-floating mb-3" id="studentIdGroup">
                        <input type="number" class="form-control" name="id" id="studentId" placeholder=" ">
                        <label for="studentId">ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" id="studentName" placeholder=" ">
                        <label for="studentName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="studentEmail" placeholder=" ">
                        <label for="studentEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="address" id="address" placeholder=" ">
                        <label for="address">Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="course" id="course" placeholder=" ">
                        <label for="course">Course</label>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitButton" style="width: 100%;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

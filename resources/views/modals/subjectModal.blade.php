<div class="modal fade" id="triggerModalSubject" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold fs-5" id="modalTitle">Subject Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <form action="" method="" id="subjectForm">
                    @csrf
                    <div class="form-floating mb-3" id="subjectIdGroup">
                        <input type="num" class="form-control" name="id" id="subjectId" placeholder="123">
                        <label for="subjectId">ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="code" id="subjectCode" placeholder="Enter Code">
                        <label for="subjectCode">Subject Code</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" id="subjectName" placeholder="Enter Name">
                        <label for="subjectName">Subject Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="units" id="units" placeholder="Enter Units">
                        <label for="units">Units</label>
                    </div>
                    <button type="submit" class="btn btn-success" id="submitButton" style="width: 100%;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

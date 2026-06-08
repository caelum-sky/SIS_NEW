<div class="modal fade" id="triggerModalInformation" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold fs-5" id="modalTitle">Enroll Subjects</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light p-4">
                <form id="enrollmentForm" method="POST" action="{{ route('enroll.store') }}">
                    @csrf
                    <input type="hidden" name="studentId" id="id">
                    <h6 class="text-secondary">Available Subjects:</h6>
                    <div id="subjectsList" class="border rounded-3 p-2 bg-white" style="max-height: 500px; overflow-y:scroll"></div>

                    <button type="submit" class="btn btn-success mt-3 fw-bold" style="width: 100%;">Enroll</button>
                </form>
            </div>
        </div>
    </div>
</div>
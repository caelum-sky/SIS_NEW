$(document).ready(function () {
    $("#triggerModalInformation").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");

        $("#id").val(id);
        $("#subjectsList").html("<p>Loading subjects...</p>");
        $.ajax({
            url: `student/${id}/subjects`,
            type: "GET",
            success: function (data) {
                $("#subjectsList").empty();

                if (data.subjects.length === 0) {
                    $("#subjectsList").html("<p>No subjects available.</p>");
                    return;
                }

                let subjects = data.subjects;
                subjects.forEach(function (subject) {
                    $("#subjectsList").append(`
                        <label class="form-check d-flex align-items-center p-3 border cursor-pointer" for="subject-${subject.id}"  style="cursor: pointer;" >
                            <input  type="checkbox" name="subjects[]" value="${subject.id}" id="subject-${subject.id}" style="transform: scale(1.5); accent-color: blue; ">
                             <label class="form-check-label" for="subject-${subject.id}">
                              ${subject.code} - ${subject.name}
                             </label>
                        </label>
                    `);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching subjects:", error);
                $("#subjectsList").html(
                    "<p>Error loading subjects. Please try again.</p>"
                );
            },
        });
    });
});

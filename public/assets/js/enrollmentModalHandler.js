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
                        <div class="d-flex align-items-center gap-2 p-2 border-bottom">
                            <input type="checkbox" name="subjects[]" value="${subject.id}" id="subject-${subject.id}" style="width:1.15em;height:1.15em;accent-color:#3B82F6;flex-shrink:0;cursor:pointer;">
                            <label class="mb-0" for="subject-${subject.id}" style="cursor:pointer;">
                                ${subject.code} - ${subject.name}
                            </label>
                        </div>
                    `);
                });
            },
            error: function () {
                $("#subjectsList").html(
                    "<p>Error loading subjects. Please try again.</p>"
                );
            },
        });
    });
});

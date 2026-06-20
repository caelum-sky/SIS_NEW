$(document).ready(function () {
    $("#triggerModalStudentInformation").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var studentId = button.data("id");
        var studentName = button.data("name");
        var studentEmail = button.data("email");
        var course = button.data("course");

        $("#student_id, #student_name, #email, #student_address").text("");
        $("#enrollmentList").empty();
        $("#student_id").text(studentId);
        $("#student_name").text(studentName);
        $("#email").text(studentEmail);
        $("#student_address").text(course);

        $.ajax({
            url: `/student/enroll/${studentId}`,
            type: "GET",
            success: function (data) {
                if (!data.length) {
                    $("#enrollmentList").html(
                        "<tr><td colspan='6' class='text-center text-muted'>Student is not yet enrolled in any subject.</td></tr>"
                    );
                    return;
                }

                data.forEach(function (enrollment) {
                    $("#enrollmentList").append(`
                        <tr>
                            <td class="eID">${enrollment.id}</td>
                            <td class="subjectCode">${enrollment.subject.code}</td>
                            <td class="subjectName">${enrollment.subject.name}</td>
                            <td>${enrollment.subject.units}</td>
                            <td class="instructor">${enrollment.instructor}</td>
                            <td>
                                <a href="#" id="editEnrollment" title="Edit enrollment" class="text-success fs-4 text-decoration-none">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" onclick="deleteSubject(${enrollment.id})" title="Remove subject" class="text-danger fs-4 text-decoration-none">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function () {
                Swal.fire("Error", "Error loading enrollments. Please try again.", "error");
            },
        });
    });
});

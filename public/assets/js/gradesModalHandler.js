$(document).ready(function () {
    $("#triggerGradesModal").on("show.bs.modal", function () {
        var studentId = $("#student_id").text();
        var sName = $("#student_name").text();
        var sEmail = $("#email").text();
        var sAddress = $("#student_address").text();

        $("#sID").text(studentId);
        $("#sName").text(sName);
        $("#sEmail").text(sEmail);
        $("#sAddress").text(sAddress);

        $.ajax({
            url: `/student/enroll/${studentId}`,
            type: "GET",
            success: function (data) {
                $("#gradeList").empty();

                if (!data.length) {
                    $("#gradeList").html(
                        "<tr><td colspan='5' class='text-center text-muted'>Student is not yet enrolled in any subject.</td></tr>"
                    );
                    return;
                }

                data.forEach(function (enrollment) {
                    $("#gradeList").append(`
                        <tr>
                            <td hidden class="enrollmentId">${enrollment.id}</td>
                            <td hidden class="gradeId">${enrollment.grade ? enrollment.grade.id : ""}</td>
                            <td class="subjectCode">${enrollment.subject.code}</td>
                            <td>${enrollment.subject.name}</td>
                            <td class="subjectGrade fw-bold">${enrollment.grade ? enrollment.grade.grade : ""}</td>
                            <td class="${enrollment.grade && enrollment.grade.status === "Passed" ? "text-success" : "text-danger"} fw-bold">
                                ${enrollment.grade ? enrollment.grade.status : "N/A"}
                            </td>
                            <td>
                                <a href="#" id="addGradeButton" title="Add grade" class="text-success fs-4 text-decoration-none">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                                <a href="#" id="editGradeButton" title="Edit grade" class="text-success fs-4 text-decoration-none">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" onclick="deleteGrade(${enrollment.grade ? enrollment.grade.id : ""})" title="Delete grade" class="text-danger fs-4 text-decoration-none">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function () {
                Swal.fire("Error", "Error loading grades. Please try again.", "error");
            },
        });
    });
});

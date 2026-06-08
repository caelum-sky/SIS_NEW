$(document).ready(function () {
    $("#triggerModalStudentInformation").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var studentId = button.data("id");
        var studentName = button.data("name");
        var studentEmail = button.data("email");
        var course = button.data("course");

        $("#student_id, #student_name, #email, #student_address").text("");
        $("#enrollmentList").empty();
        if (!$("#student_id").text().trim()) {
            $("#student_id").text(studentId);
            $("#student_name").text(studentName);
            $("#email").text(studentEmail);
            $("#student_address").text(course);
        }

        console.log(studentId);
        $.ajax({
            url: `/student/enroll/${studentId}`,
            type: "GET",
            success: function (data) {
                console.log(data);
                if ($("#enrollmentList").children().length === 0) {
                    if (data.length > 0) {
                        data.forEach(function (enrollment) {
                            var actionUrl = `student/enroll/${enrollment.id}`;
                            $("#IdToDelete").attr("action", actionUrl);
                            $("#enrollmentList").append(`
                                <tr>
                                    <td class="eID">${enrollment.id}</td>
                                    <td class="subjectCode">${enrollment.subject.code}</td>
                                    <td class="subjectName">${enrollment.subject.name}</td>
                                    <td>${enrollment.subject.units}</td>
                                    <td class="instructor">${enrollment.instructor}</td>
                                    <td> 
                                     <a href="#"id="editEnrollment"  style="font-size: 1.5rem; color: green; text-decoration: none;">
                                          ➕
                                        </a>
                                        <a href="#"  onclick="deleteSubject(${enrollment.id})"style="font-size: 1.5rem; color: red; text-decoration: none;">
                                            🗑️
                                        </a>
                                       
                                    </td>
                              
                                </tr>
                            `);
                        });
                    } else {
                        $("#enrollmentList").html(
                            "<tr><td colspan='5' style='text-align:center'>Student not yet enrolled to any subject</td></tr>"
                        );
                    }
                }
            },
            error: function () {
                alert("Error loading enrollments.");
            },
        });
    });
});

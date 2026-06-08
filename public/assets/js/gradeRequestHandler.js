$(document).ready(function () {
    $(document).on("click", "#addGradeButton", function () {
        var studentId = $("#student_id").text();
        var row = $(this).closest("tr");
        var grade = row.find(".subjectGrade").text();
        var enrollmentId = row.find(".enrollmentId").text();
        var subjectCode = row.find(".subjectCode").text();
        console.log("ahsdjkfhajksdf: ", enrollmentId);
        var actionUrl = "/grade";
        if (grade !== "") {
            return;
        }
        console.log(studentId);
        $("#triggerGradesModal").css({
            "z-index": "1040",
            display: "block",
        });

        $("#gradeForm").attr("action", actionUrl);
        $(".modal-backdrop").css("z-index", "1039");
        $("#triggerAddGradeModal").css("z-index", "2050").modal("show");
        $("#studentIdGrade").val(studentId);
        $("#enrollment_id").val(enrollmentId);
        $("#sCode").prop("disabled", true);
        $("#studentIdGrade").prop("disabled", true);
        $("#sCode").val(subjectCode);
        $("#gradeModalTitle").text("Add Grade");
    });

    $(document).on("click", "#editGradeButton", function () {
        var studentId = $("#student_id").text();
        var row = $(this).closest("tr");
        var subjectCode = row.find(".subjectCode").text();
        var gradeId = row.find(".gradeId").text();
        var grade = row.find(".subjectGrade").text();
        var actionUrl = `/grade/${gradeId}`;
        if (grade === "") {
            return;
        }
        $("#triggerGradesModal").css({
            "z-index": "1040",
            display: "block",
        });

        $(".modal-backdrop").css("z-index", "1039");
        $("#triggerAddGradeModal").css("z-index", "2050").modal("show");
        $("#gradeForm").append(
            '<input type="hidden" name="_method" value="PUT">'
        );
        $("#gradeForm").attr("action", actionUrl);
        $("#studentIdGrade").val(studentId);
        $("#studentIdGrade").prop("disabled", true);
        $("#sCode").val(subjectCode);
        $("#sCode").prop("disabled", true);
        $("#grade").val(grade);
        $("#gradeModalTitle").text("Update Grade");
    });

    $("#triggerAddGradeModal").on("hidden.bs.modal", function () {
        $("#triggerGradesModal").css("z-index", "1050");
        $("#studentIdGrade").val("");
        $("#sCode").val("");
        $("#grade").val("");
        $("#gradeModalTitle").text("");
        $("#subjectForm input[name='_method']").remove();
    });
});

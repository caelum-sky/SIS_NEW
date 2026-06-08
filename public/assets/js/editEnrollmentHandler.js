$(document).ready(function () {
    $(document).on("click", "#editEnrollment", function () {
        var row = $(this).closest("tr");

        var eID = row.find(".eID").text();
        console.log("asjdfklhjasdjkfhajksfhkasd", eID);
        var subjectCode = row.find(".subjectCode").text();
        var subjectName = row.find(".subjectName").text();
        var instructor = row.find(".instructor").text();
        $("#triggerModalStudentInformation").css({
            "z-index": "1039",
            display: "block",
        });
        $(".modal-backdrop").css("z-index", "1040");
        $("#triggerEditEnrollment").css("z-index", "2050").modal("show");
        $("#editEnrollmentForm").attr("action", `/student/enroll/${eID}`);
        $("#editEnrollmentForm").append(
            '<input type="hidden" name="_method" value="PUT">'
        );
        $("#subjectCode1").val(subjectCode);
        $("#subjectName1").val(subjectName);
        $("#instructor").val(instructor);
    });
    $("#triggerEditEnrollment").on("hidden.bs.modal", function () {
        $("#triggerModalStudentInformation").css("z-index", "1050");
        $("#subjectCode1").val("");
        $("#subjectName1").val("");
        $("#instructor").val("");
    });
});

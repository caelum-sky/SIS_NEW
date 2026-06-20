$(document).ready(function () {
    $("#triggerModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var mode = button.data("mode");
        var id = button.data("id") || "";
        var name = button.data("name") || "";
        var email = button.data("email") || "";
        var address = button.data("address") || "";
        var course = button.data("course") || "";
        var actionUrl = button.data("action");

        if (mode === "edit") {
            $("#modalTitle").text("Edit Student");
            $("#submitButton").text("Update Student");
            $("#studentId").prop("disabled", true);
            $("#studentEmail").prop("disabled", false);
            $("#studentIdGroup").show();
            $("#studentForm input[name='_method']").remove();
            $("#studentForm").append(
                '<input type="hidden" name="_method" value="PUT">'
            );
        } else {
            $("#modalTitle").text("Add Student");
            $("#submitButton").text("Add Student");
            $("#studentIdGroup").hide();
            $("#studentEmail").prop("disabled", false);
            $("#studentForm input[name='_method']").remove();
        }
        $("#studentForm").attr("method", "POST");
        $("#studentForm").attr("action", actionUrl);
        $("#studentId").val(id);
        $("#studentName").val(name);
        $("#studentEmail").val(email);
        $("#address").val(address);
        $("#course").val(course);
    });
    $("#triggerModal").on("hidden.bs.modal", function () {
        $("#studentForm")[0].reset();
        $("#studentId").val("");
        $("#studentForm input[name='_method']").remove();
    });
});

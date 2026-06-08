$(document).ready(function () {
    $("#triggerModalSubject").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var mode = button.data("mode");
        var id = button.data("id") || "";
        var code = button.data("code") || "";
        var name = button.data("name") || "";
        var units = button.data("units") || "";
        var actionUrl = button.data("action");
        console.log(actionUrl);
        if (mode === "edit") {
            $("#modalTitle").text("Edit Subject");
            $("#submitButton").text("Update Subject");
            $("#subjectId").prop("disabled", true);
            $("#subjectCode").prop("disabled", true);
            $("#subjectIdGroup").show();
            $("#subjectForm").append(
                '<input type="hidden" name="_method" value="PUT">'
            );
        } else {
            $("#modalTitle").text("Add Subject");
            $("#submitButton").text("Add Subject");
            $("#subjectIdGroup").hide();
            $("#subjectCode").prop("disabled", false);
            $("#subjectForm input[name='_method']").remove();
        }
        $("#subjectForm").attr("method", "POST");
        $("#subjectForm").attr("action", actionUrl);
        $("#subjectId").val(id);
        $("#subjectCode").val(code);
        $("#subjectName").val(name);
        $("#units").val(units);
    });
    $("#triggerModalSubjects").on("hidden.bs.modal", function () {
        $("#subjectForm")[0].reset();
        $("#subjectId").val("");
        $("#subjectForm input[name='_method']").remove();
    });
});

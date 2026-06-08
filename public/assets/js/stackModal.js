$(document).ready(function () {
    $("#gradesModal").click(function () {
        console.log("asdjhfkjasfsf");
        $("#triggerGradesModal").modal({
            show: true,
        });
    });

    $(document).on("show.bs.modal", ".modal", function (event) {
        var zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(function () {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });
});

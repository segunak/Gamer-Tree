$("#forgotmodal").modal("show").on("shown", function () {
    window.setTimeout(function () {
        $("#forgotmodal").modal("hide");
    }, 5000);
});

$(document).ready(function () {

    // form validation
    $('form').parsley();

    // delete confirmation
    if ($(".btn-danger:not(.btn-delete-file)").length > 0) {
        runConfirm();
    }
});

function runConfirm() {
    $(".btn-danger").confirm({
        text: text_confirm_delete,
        confirmButton: text_confirm,
        cancelButton: text_cancel,
        post: true,
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-secondary",
        dialogClass: "modal-dialog modal-full-color modal-full-color-danger modal-lg" // Bootstrap classes for large modal
    });
}
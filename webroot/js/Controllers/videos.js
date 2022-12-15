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
        confirm: (e) => {
            const url = $(e).attr('href');
            const form = $('<form method="post" class="hide" action="' + url + '"><input type="hidden" name="_csrfToken" value="'+csrfToken+'" /></form>');
            $("body").append(form);
            form.submit();
        },
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-secondary",
        dialogClass: "modal-dialog modal-full-color modal-full-color-danger modal-lg" // Bootstrap classes for large modal
    });
}

$(document).ready(function () {

    $('[data-toggle="popover"]').popover({
        container: 'body',
        placement: 'top',
        trigger: 'hover',
        html: true
    });

    // delete confirmation
    if( $(".btn-confirm").length > 0 ){
        runConfirm();
    }

});

function runConfirm(){
    $(".btn-confirm").confirm({
        text: text_confirm_delete,
        confirmButton: text_confirm,
        cancelButton: text_cancel,
        post: true,
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-secondary",
        dialogClass: "modal-dialog modal-full-color modal-full-color-danger modal-lg" // Bootstrap classes for large modal
    });
}
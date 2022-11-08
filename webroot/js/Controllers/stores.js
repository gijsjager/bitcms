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

function fetchGEO() {
    var geocoder = new google.maps.Geocoder();
    var address = '';
    $('.address-data input[type="text"]').each(function () {
        if ($(this).val() != "") {
            address += ' ' + $(this).val();
        }
    });
    if (address != '') {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == 'OK') {
                $('#lat').val( results[0].geometry.location.lat() );
                $('#lng').val( results[0].geometry.location.lng() );
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
}
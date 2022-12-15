$(document).ready(function(){
    $('#cropper').cropper({
        aspectRatio: 16 / 9,
        dragMode: 'move'
    });

    // delete confirmation
    if( $(".btn-danger").length > 0 ){
        runConfirm();
    }
});

function setImage(image){
    var url = $(image).val();
    var input = image;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#cropper')
                .cropper('destroy')
                .attr('src', e.target.result)
                .cropper({ aspectRatio: 16 / 9, dragMode: 'move' });
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        alert('this is not an image!');
    }
}

function setRation(ratio){
    $('#cropper').cropper('setAspectRatio', ratio);
}

function getCrop(){
    var c = $('#cropper').cropper('getCroppedCanvas').toDataURL('image/jpeg');
    $('#image').val(c);
    $('#crop-form').submit();
    return false;
}

function cropImage( imageId ) {

    $('.crop-image .btn-primary').replaceWith('<span class="loading"></span>');

    $('#cropper').cropper('getCroppedCanvas').toBlob( function(blob) {

        var formData = new FormData();
        formData.append('croppedImage', blob);

        $.ajax({
            url: d + '/images/crop/' + imageId,
            data: formData,
            processData: false,
            contentType: false,
            type: 'post'
        }).done(function(response){
            // console.log(response);
            window.location.reload();
        });
    });
}

function runConfirm(){
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

$(document).ready(function () {

    // sorting
    if( $('.dd').length > 0 ){
        runNestable();
    }

    // form validation
    $('form').parsley();

    // delete confirmation
    if( $(".btn-danger").length > 0 ){
        runConfirm();
    }

    $('.btn-add-blockgroup').on('click', function(e){
        e.preventDefault();
        addBlockGroup( 'Pages', $('.block-group-add').length );
    });
});

function runNestable(){
    $('.dd').nestable({
        maxDepth: 2
    }).on('change', function(){
        var data = $('.dd').nestable('serialize');
        $.ajax({
            url:    $('.dd').data('url'),
            data:   {
                positions: data
            },
            type:   'post'
        }).done(function(response){
            // console.log(response);
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

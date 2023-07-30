var BitCMS;

// disable autoload dropzone
Dropzone.autoDiscover = false;

// csrf tokens
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    jqXHR.setRequestHeader('X-CSRF-Token', csrfToken);
});

// modal defaults
$.fn.niftyModal('setDefaults', {
    overlaySelector: '.modal-overlay',
    contentSelector: '.modal-content',
    closeSelector: '.modal-close',
    classAddAfterOpen: 'modal-show',
    classModalOpen: 'modal-open',
    classScrollbarMeasure: 'modal-scrollbar-measure',
    afterOpen: function () {
        $("html").addClass('mai-modal-open');
    },
    afterClose: function () {
        $("html").removeClass('mai-modal-open');
    }
});

BitCMS = (function () {

    var functions = {};

    var imageConfirm = functions.imageConfirm = function setImageConfirm() {
        $(".delete-image").confirm({
            text: text_confirm_delete,
            confirmButton: text_confirm,
            cancelButton: text_cancel,
            confirm: function (button) {
                $.ajax({
                    url: $(button).attr('href'),
                    type: 'post'
                }).done(function (response) {
                    $('#image-' + $(button).data('id')).addClass('animated bounceOut');
                    setTimeout(function () {
                        $('#image-' + $(button).data('id')).remove();
                    }, 1000);
                });
            },
            post: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-secondary",
            dialogClass: "modal-dialog modal-full-color modal-full-color-danger modal-lg" // Bootstrap classes for large modal
        });
    };
    var fileConfirm = functions.fileConfirm = function setFileConfirm() {
        $(".btn-delete-file").confirm({
            text: text_confirm_delete,
            confirmButton: text_confirm,
            cancelButton: text_cancel,
            confirm: function (button) {
                $.ajax({
                    url: $(button).attr('href'),
                    type: 'post'
                }).done(function (response) {
                    $('#file-' + $(button).data('id')).addClass('animated bounceOut');
                    setTimeout(function () {
                        $('#file-' + $(button).data('id')).remove();
                    }, 1000);
                });
            },
            post: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-secondary",
            dialogClass: "modal-dialog modal-full-color modal-full-color-danger modal-lg" // Bootstrap classes for large modal
        });
    };
    function runFileupload() {
        if ($('.fileupload').length > 0) {

            $('.fileupload').each(function () {
                $(this).dropzone({
                    url: d + "/files/upload",
                    maxFilesize: maxUploadSize,
                    dictDefaultMessage: text_upload_file,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    sending: function (file, xhr, formData) {
                        var $elm = $(this.element);
                        formData.append('entity_id', $elm.data('entity-id'));
                        formData.append('model', $elm.data('model'));
                    },
                    complete: function (file) {

                        if (file.accepted == true) {

                            this.removeFile(file);
                            var $elm = $(this.element);

                            $elm.closest('.files-list').find('.file-list-currently-uploaded').html('<span class="loading"></span>');

                            // reload image overview
                            $.ajax({
                                url: d + '/files/reload_overview',
                                type: 'post',
                                data: {
                                    entity_id: $elm.data('entity-id'),
                                    model: $elm.data('model')
                                }
                            }).done(function (template) {
                                $elm.closest('.files-list').find('.file-list-currently-uploaded').html(template);
                                BitCMS.refresh('fileConfirm');
                                BitCMS.refresh('fileEdit');
                            });
                        }
                    }
                });
            });

        }
    }
    function runDropzone() {
        if ($('.my-dz').length > 0) {

            $('.my-dz').each(function () {
                $(this).dropzone({
                    url: d + "/images/upload",
                    maxFilesize: (maxUploadSize > 8 ) ? 8 : maxUploadSize,
                    acceptedFiles: 'image/*',
                    dictDefaultMessage: text_upload_image,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    sending: function (file, xhr, formData) {
                        var $elm = $(this.element);
                        formData.append('entity_id', $elm.data('entity-id'));
                        formData.append('model', $elm.data('model'));
                    },
                    complete: function (file) {

                        if (file.accepted == true) {

                            this.removeFile(file);
                            var $elm = $(this.element);

                            $elm.closest('.image-list').find('.image-list-currently-uploaded').html('<span class="loading"></span>');

                            // reload image overview
                            $.ajax({
                                url: d + '/images/reload_overview',
                                type: 'post',
                                data: {
                                    entity_id: $elm.data('entity-id'),
                                    model: $elm.data('model')
                                }
                            }).done(function (template) {
                                $elm.closest('.image-list').find('.image-list-currently-uploaded').html(template);
                                BitCMS.refresh('imageConfirm');
                                BitCMS.refresh('runMovable');
                            });
                        }
                    }
                });
            });

        }
    }
    function runHtmlEditors() {
        // html editors


        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/bitcms/images/inlineUpload');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        $('.html-editor').each(function () {

            tinymce.init({
                selector: '.html-editor',
                skin: 'bootstrap',
                icons: 'small',
                menubar: false,
                content_css: '/bitcms/css/editor.css',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table wordcount code',
                toolbar: 'bold italic underline strikethrough | blocks | alignleft aligncenter alignright alignjustify | numlist bullist | removeformat | table charmap emoticons | fullscreen  preview | insertfile image media template link anchor code',
                toolbar_mode: 'wrap',
                toolbar_sticky: true,
                tinycomments_mode: 'embedded',
                tinycomments_author: 'BitCMS',
                /* without images_upload_url set, Upload tab won't show up*/
                images_upload_handler: example_image_upload_handler,
                link_class_list: [
                    {title: 'None', value: ''},
                    {title: 'Button primary', value: 'btn btn-primary'},
                    {title: 'Button secondary', value: 'btn btn-secondary'},
                    {title: 'Button dark', value: 'btn btn-dark'},
                ],
                mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                ]
            });

        });
        $('.note-popover').css({'display': 'none'});
    }

    function runSelect2() {
        if ($('.select2').length > 0) {
            $('.select2').select2();
        }
    }

    var runMovable = functions.runMovable = function runMovable() {
        $('.movable').each(function () {
            var $container = $(this);
            console.log($container);
            $container.sortable({
                handle: '.move-handler',
                update: function(){
                    var list = $container.sortable('toArray');
                    $.ajax({
                        url: $container.data('sortable-url'),
                        type: 'post',
                        data: {items: list}
                    });
                }
            })
        });
    }

    var fileEdit = functions.fileEdit = function runFileEdit() {
        if ($('.btn-file-edit').length > 0) {

            $('.btn-file-edit').click(function (e) {
                e.preventDefault();
                $('#file-edit-modal').remove();
                $elm = $(this);
                $.ajax({
                    url: $(this).attr('href')
                }).done(function (template) {
                    $('body').append(template);
                    $('#file-edit-modal').niftyModal();

                    $('#file-edit-modal form').submit(function () {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'post',
                            data: $(this).serialize()
                        }).done(function (response) {
                            $('#file-edit-modal').niftyModal('hide');
                            $.ajax({
                                url: d + '/files/reload_overview',
                                type: 'post',
                                data: {
                                    entity_id: $elm.data('entity-id'),
                                    model: $elm.data('model')
                                }
                            }).done(function (template) {
                                $elm.closest('.files-list').find('.file-list-currently-uploaded').html(template);
                                BitCMS.refresh('fileConfirm');
                                BitCMS.refresh('fileEdit');
                            });
                        });
                        return false;
                    });

                });
            });
        }
    };
    const runPopover = () => {
        // Popover
        $('[data-toggle="popover"]').popover();
    }

    var runConfirm = functions.runConfirm = function runConfirm() {

        $('.btn-confirm').each(function(){
            $(this).confirm({
                text: $(this).data('text') ? $(this).data('text') : 'Are you sure you want to delete this item',
                confirmButton: 'Yes',
                cancelButton: 'Cancel',
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
        })


    }

    return {
        init: function () {
            imageConfirm();
            runDropzone();
            runHtmlEditors();
            runSelect2();
            runMovable();

            fileConfirm();
            runFileupload();
            fileEdit();
            runPopover();
            runConfirm();

        },
        refresh: function (functionToRerun) {
            functions[functionToRerun].call();
        }
    };
})();

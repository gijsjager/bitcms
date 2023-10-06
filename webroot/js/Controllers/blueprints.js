$(document).ready(function () {
    $('.add-field').on('click', addField);
    $('body').on('click', '.delete-field', deleteField);
});

function addField() {
    $.get('/bitcms/blueprints/get_new_field', function (data) {
        $('.fields').append(data);
    });
}

function deleteField() {
    if (confirm('Are you sure you want to delete this field?') === false) {
        return;
    }
    $(this).closest('.panel').remove();
}
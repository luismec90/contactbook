var contactsTable;

$(function () {
    contactsTable = $('#contacts-table').DataTable();

    $('#create-contact').click(function () {
        $('#form-create-contact')[0].reset();
        $('#modal-create-contact').modal();
    });

    $('.add-custom-field').click(function () {
        var totalCustomFields = $('#custom-fields-container .row').length;
        if (totalCustomFields < 5) {
            var clonedDiv = $('#custom-fields-container .row:first').clone();
            clonedDiv.find("input:text").val("");
            clonedDiv.appendTo('#custom-fields-container');
        }
        if (totalCustomFields == 4)
            $(this).attr('disabled', true);
    });

    $(document.body).on('click', '.remove-custom-field', function () {
        var totalCustomFields = $('#custom-fields-container .row').length;
        if (totalCustomFields <= 5)
            $(this).parent().parent().parent().parent().find('.add-custom-field').removeAttr('disabled');
        if (totalCustomFields > 1)
            $(this).parent().parent().remove();
    });

    $('#form-create-contact').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (data) {
                coverOff();
                addRow(data.contact);
                $('#modal-create-contact').modal('hide');
                showMessage('Contact created!', 'success');
            }, error: function (response) {
                coverOff();
                $('#modal-create-contact').modal('hide');

                if (response.status == 422) {
                    $('#error-list').html(response.responseText);
                } else {
                    showMessage('Something went wrong, please try again.', 'danger');
                }
            }
        });

        return false;
    });

    $(document.body).on('click', '.custom-data', function () {
        $('#modal-custom-data').modal();
    });

    $(document.body).on('click', '.edit-contact', function () {
        $('#modal-edit-contact').modal();
    });

    $(document.body).on('click', '.delete-contact', function () {
        var contactID = $(this).data('contact-id')
        var contactName = $(this).data('contact-name')
        var route = '/contacts/' + contactID;
        $('#form-delete-contact').attr('action', route);
        $('#delete-contact-name').html(contactName);
        $('#modal-delete-contact').modal();
    });

    $('#form-delete-contact').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (data) {
                coverOff();
                $('#tr-' + data.contactID).remove();
                $('#modal-delete-contact').modal('hide');
                showMessage('Contact deleted!', 'success');
            }, error: function (response) {
                coverOff();
                $('#modal-delete-contact').modal('hide');
                if (response.status == 422) {
                    showErrors(response.responseText);
                } else {
                    showMessage('Something went wrong, please try again.', 'danger');
                }
            }
        });

        return false;
    });
});

function addRow(contact) {

    var editBtn = '';
    var deleteBtn = '<button class="btn btn-danger btn-xs delete-contact" data-contact-id="' + contact.id + '" data-contact-name="' + contact.name + '"> <span class="glyphicon glyphicon-trash"></span> </button>';

    var rowNode = contactsTable
        .row.add([contact.name, contact.surname, contact.email, contact.phone, '-', 'asdsad', deleteBtn])
        .draw()
        .node();

    $(rowNode).attr('id', 'tr-' + contact.id);

}

function coverOn() {
    $("#cover-display").css({
        "opacity": "1",
        "width": "100%",
        "height": "100%"
    });
}

function coverOff() {
    $("#cover-display").css({
        "opacity": "0",
        "width": "0",
        "height": "0"
    });
}

function showMessage(message, type) {
    $.notify({
        message: message
    }, {
        type: type,
        placement: {
            from: "top",
            align: "center"
        }
    });
}

function handleErrors(errors) {

}
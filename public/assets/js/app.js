$(function () {


    $('#create-contact').click(function () {
        $('#form-create-contact')[0].reset();
        $('#modal-create-contact').modal();
    });

    $('#add-custom-field').click(function () {
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
            $(this).parent().parent().parent().parent().find('#add-custom-field').removeAttr('disabled');
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
                $('#modal-create-contact').modal('hide');
                updateContactsTable(data);
                showMessage('Contact created!', 'success');
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });

    $(document.body).on('click', '.custom-data', function () {
        var contactID = $(this).data('contact-id')
        var route = '/contacts/' + contactID + '/custom-data';
        $('#form-custom-data').attr('action', route);
        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                var totalCustomFields;
                $('#add-custom-field').attr('disabled', false);
                $('#custom-fields-container .row:not(:first)').remove();
                $.each(data, function (index, element) {
                    if (index == 0) {
                        $('#custom-fields-container .row:first').find("input:text").val(element.content);
                    } else {
                        var clonedDiv = $('#custom-fields-container .row:first').clone();
                        clonedDiv.find("input:text").val(element.content);
                        clonedDiv.appendTo('#custom-fields-container');
                    }
                });
                if (data.length >= 5) {
                    $('#add-custom-field').attr('disabled', true);
                }
                $('#modal-custom-data').modal();
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });

    $('#form-custom-data').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (data) {
                coverOff();

                $('#modal-custom-data').modal('hide');
                showMessage('Custom info updated!', 'success');
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });


    $(document.body).on('click', '.edit-contact', function () {
        var contactID = $(this).data('contact-id')
        var route = '/contacts/' + contactID;
        $('#form-edit-contact').attr('action', route);

        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#edit-name').val(data.name);
                $('#edit-surname').val(data.surname);
                $('#edit-email').val(data.email);
                $('#edit-phone').val(data.phone);
                $('#modal-edit-contact').modal();
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });

    $('#form-edit-contact').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (data) {
                coverOff();
                $('#modal-edit-contact').modal('hide');
                updateContactsTable(data);
                showMessage('Contact updated!', 'success');
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
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
                handleAjaxErrors(response);
            }
        });

        return false;
    });
});

function updateContactsTable(contact) {
    console.log(contact);

    var customDataBtn = '<button></button>';
    var editBtn = ' <button class="btn btn-primary btn-xs edit-contact" title="Edit contact." data-contact-id="' + contact.id + '"><span class="glyphicon glyphicon-pencil"></span></button>';
    var deleteBtn = '<button class="btn btn-danger btn-xs delete-contact" title="Delete contact." data-contact-id="' + contact.id + '" data-contact-name="' + contact.name + '"> <span class="glyphicon glyphicon-trash"></span> </button>';

    var data = [contact.name, contact.surname, contact.email, contact.phone, customDataBtn, editBtn, deleteBtn];

    if ($('#tr-' + contact.id) == []) {
        var rowNode = contactsTable
            .row.add(data)
            .draw()
            .node();
        $(rowNode).attr('id', 'tr-' + contact.id);
    } else {
        contactsTable
            .row($('#tr-' + contact.id))
            .data(data)
            .draw();
    }
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
        },
        z_index: 1060
    });
}

function handleAjaxErrors(response) {
    if (response.status == 422) {
        var errorsList = '<ul>';
        var json = JSON.parse(response.responseText);
        $.each(json.errors, function (index, element) {
            errorsList = errorsList + '<li>' + element + '</li>'
        });
        errorsList = errorsList + '</ul>';
        showMessage(errorsList, 'danger');
    } else {
        showMessage('Something went wrong, please try again.', 'danger');
    }
}
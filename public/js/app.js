$(function () {

    /*
     *  CRUD Buttons
     */
    $('#create-contact').click(function () {
        $('#form-create-contact')[0].reset();
        $('#modal-create-contact').modal();
    });

    $(document.body).on('click', '.edit-contact', function () {
        var contactID = $(this).data('contact-id')
        var route = '/contacts/' + contactID;
        $('#form-edit-contact').attr('action', route);
        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            success: function (response) {
                var contact = response.data;
                $('#edit-name').val(contact.name);
                $('#edit-surname').val(contact.surname);
                $('#edit-email').val(contact.email);
                $('#edit-phone').val(contact.phone);
                $('#modal-edit-contact').modal();
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });

    $('#add-custom-data').click(function () {
        var totalCustomData = $('#custom-data-container .row').length;
        if (totalCustomData < 5) {
            var clonedDiv = $('#custom-data-container .row:first').clone();
            clonedDiv.find("input:text").val("");
            clonedDiv.appendTo('#custom-data-container');
        }
        if (totalCustomData == 4)
            $(this).attr('disabled', true);
    });

    $(document.body).on('click', '.remove-custom-data', function () {
        var totalCustomData = $('#custom-data-container .row').length;
        if (totalCustomData <= 5)
            $(this).parent().parent().parent().parent().find('#add-custom-data').removeAttr('disabled');
        if (totalCustomData > 1)
            $(this).parent().parent().remove();
    });

    $(document.body).on('click', '.custom-data', function () {
        var contactID = $(this).data('contact-id')
        var route = '/contacts/' + contactID + '/custom-data';
        $('#form-custom-data').attr('action', route);
        $.ajax({
            url: route,
            type: 'GET',
            dataType: 'JSON',
            success: function (response) {
                var totalCustomData;
                $('#add-custom-data').attr('disabled', false);
                $('#custom-data-container .row:not(:first)').remove();
                $.each(response.data, function (index, element) {
                    if (index == 0) {
                        $('#custom-data-container .row:first').find("input:text").val(element.content);
                    } else {
                        var clonedDiv = $('#custom-data-container .row:first').clone();
                        clonedDiv.find("input:text").val(element.content);
                        clonedDiv.appendTo('#custom-data-container');
                    }
                });
                if (response.data.length >= 5) {
                    $('#add-custom-data').attr('disabled', true);
                }
                $('#modal-custom-data').modal();
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

    $('#form-create-contact').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (response) {
                coverOff();
                $('#modal-create-contact').modal('hide');
                updateContactsTable();
                showMessage(response.message, 'success');
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });

    /*
     *   SUBMIT FORMS
     */
    $('#form-edit-contact').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (response) {
                coverOff();
                $('#modal-edit-contact').modal('hide');
                updateContactsTable();
                showMessage(response.message, 'success');
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
            success: function (response) {
                coverOff();
                $('#modal-custom-data').modal('hide');
                showMessage(response.message, 'success');
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });


    $('#form-delete-contact').submit(function (e) {
        coverOn();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
            success: function (response) {
                coverOff();
                updateContactsTable();
                $('#modal-delete-contact').modal('hide');
                showMessage(response.message, 'success');
            }, error: function (response) {
                coverOff();
                handleAjaxErrors(response);
            }
        });

        return false;
    });


    $('#search').keyup(function () {

        var criteria = $(this).val();

        $.ajax({
            url: '/search/contacts/' + criteria,
            type: 'GET',
            dataType: 'JSON',
            success: function (response) {
                $('#container-contact-list').html(response.data)
            }, error: function (response) {
                handleAjaxErrors(response);
            }
        });

    });
});

/*
 * HELPERS
 */
function updateContactsTable() {
    $.ajax({
        url: '/contacts',
        type: 'GET',
        dataType: 'JSON',
        success: function (response) {
            $('#container-contact-list').html(response.data)
        }, error: function (response) {
            handleAjaxErrors(response);
        }
    });
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
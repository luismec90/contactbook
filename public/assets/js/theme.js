$(function () {


});

function addRow(contact){

    var editBtn='';
    var deleteBtn='<button class="btn btn-danger btn-xs delete-contact" data-contact-id="'+contact.id+'" data-contact-name="'+contact.name+'"> <span class="glyphicon glyphicon-trash"></span> </button>';

    var rowNode = contactsTable
        .row.add([contact.name, contact.surname, contact.email,contact.phone,'-','asdsad',deleteBtn])
        .draw()
        .node();

    $(rowNode).attr('id','tr-'+contact.id)
        .css('color', 'red')
        .animate({color: 'black'})
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
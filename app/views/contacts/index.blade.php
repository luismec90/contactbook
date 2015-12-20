@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>

    <script>
        var contactsStore = '{{ route('contacts.store') }}';

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
                    url: contactsStore,
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

            $(document.body).on('click', '.edit-contact', function () {
                $('#modal-edit-contact').modal();
            });

            $(document.body).on('click', '.delete-contact', function () {

                var contactID = $(this).data('contact-id')
                var contactName = $(this).data('contact-name')

                var route ='/contacts/'+contactID;

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
    </script>
@stop


@section('content')

    <h2>Contact List
        <button id="create-contact" class="btn btn-primary pull-right">Create</button>
    </h2>
    <hr>

    <div id="error-list"></div>
    <div id="container-contact-list">
        @include('contacts.partials.list')
    </div>

    <div class="modal fade" id="modal-create-contact">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['id'=>'form-create-contact','route'=>'contacts.store']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create contact</h4>
                </div>
                <div class="modal-body">

                    @include('contacts.partials.createUpdateForm')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
                {{ Form::close() }}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div class="modal fade" id="modal-edit-contact">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['id'=>'form-edit-contact','route'=>'contacts.update','method'=>'PUT']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit contact</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                {{ Form::close() }}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-delete-contact">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['id'=>'form-delete-contact','method'=>'DELETE']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete contact</h4>
                </div>
                <div class="modal-body">
                    <p> Are you sure you want to delete <b id="delete-contact-name"></b> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                {{ Form::close() }}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
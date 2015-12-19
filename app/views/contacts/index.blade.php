@extends('layouts.master')



@section('js')
    <script>
        var contactsStore = '{{ route('contacts.store') }}';

        $(function () {

            $('.add-custom-field').click(function () {
                var totalCustomFields = $('#custom-fields-container .row').length;
                if (totalCustomFields >= 5)
                    $(this).attr('disabled', true);
                else {
                    var clonedDiv = $('#custom-fields-container .row:first').clone();
                    clonedDiv.find("input:text").val("");
                    clonedDiv.appendTo('#custom-fields-container');
                }
            });

            $(document.body).on('click', '.remove-custom-field', function () {
                var totalCustomFields = $('#custom-fields-container .row').length;
                if (totalCustomFields <= 5)
                    $(this).parent().parent().parent().parent().find('.add-custom-field').removeAttr('disabled');
                if (totalCustomFields > 1)
                    $(this).parent().parent().remove();
            });

            $('#form-create-contact').submit(function (e) {

                $.ajax({
                    method: 'POST',
                    type: 'JSON',
                    url: contactsStore,
                    data: $(this).serialize(),
                    success: function (data) {
                        console.log(data);
                    }
                });

                return false;
            });

            $(document.body).on('click', '.edit-contact', function () {
                $('#modal-edit-contact').modal();
            });

            $(document.body).on('click', '.delete-contact', function () {
                $('#modal-delete-contact').modal();
            });
        });
    </script>
@stop

@section('css')

    <style>
        #custom-fields-container .row {
            margin-bottom: 20px;
        }

        #custom-fields-container .row:first-child .remove-custom-field {
            display: none;
        }
    </style>
@stop

@section('content')

    <h2>Contact List
        <button class="btn btn-primary pull-right" data-toggle="modal" href="#modal-create-contact">Create</button>
    </h2>
    <hr>
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
                    @include('contacts.partials.createUpdateForm')
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
                {{ Form::open(['id'=>'form-edit-contact','route'=>'contacts.update','method'=>'PUT']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete contact</h4>
                </div>
                <div class="modal-body">

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
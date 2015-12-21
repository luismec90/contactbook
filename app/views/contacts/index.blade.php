@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(function () {
            contactsTable = $('#contacts-table').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false},
                    {"orderable": false},
                ],
                "bPaginate": false,
                "info": false
            });
        });
    </script>
@stop

@section('content')

    <h2>Contact List
        <button id="create-contact" class="btn btn-primary pull-right">Create</button>
    </h2>
    <hr>

    <div id="container-contact-list">
        <table id="contacts-table" class="table table-stripped table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Custom fields</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $contact)
                <tr id="tr-{{ $contact->id }}">
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->surname }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>
                        <button class="btn btn-primary btn-xs custom-data" title="Contact custom info."
                                data-contact-id="{{ $contact->id }}"><span
                                    class="glyphicon glyphicon-info-sign"></span></button>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-xs edit-contact" title="Edit contact."
                                data-contact-id="{{ $contact->id }}"><span
                                    class="glyphicon glyphicon-pencil"></span></button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs delete-contact" title="Delete contact."
                                data-contact-id="{{ $contact->id }}"
                                data-contact-name="{{ $contact->name }}">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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

                    <div class="form-group">
                        {{ Form::label('name','Name:') }}
                        {{ Form::text('name',null,['class'=>'form-control','required'=>'required']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('surname','Surname:') }}
                        {{ Form::text('surname',null,['class'=>'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('email','Email:') }}
                        {{ Form::email('email',null,['class'=>'form-control','required'=>'required']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('phone','Phone:') }}
                        {{ Form::text('phone',null,['class'=>'form-control']) }}
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
                {{ Form::close() }}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-custom-data">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['id'=>'form-custom-data','method'=>'PUT']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Contact custom fields</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <a id="add-custom-data" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-plus"></span> Add custom field
                            </a>
                        </div>
                    </div>
                    <br>
                    <div id="custom-data-container">
                        <div class="row">
                            <div class="col-xs-9 col-sm-10">
                                {{ Form::text(null,null,['name'=>'customData[]','class'=>'form-control']) }}
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a class="remove-custom-data btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {{ Form::close() }}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <div class="modal fade" id="modal-edit-contact">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['id'=>'form-edit-contact','method'=>'PUT']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit contact</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('name','Name:') }}
                        {{ Form::text('name',null,['id'=>'edit-name','class'=>'form-control','required'=>'required']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('surname','Surname:') }}
                        {{ Form::text('surname',null,['id'=>'edit-surname','class'=>'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('email','Email:') }}
                        {{ Form::email('email',null,['id'=>'edit-email','class'=>'form-control','required'=>'required']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('phone','Phone:') }}
                        {{ Form::text('phone',null,['id'=>'edit-phone','class'=>'form-control']) }}
                    </div>

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
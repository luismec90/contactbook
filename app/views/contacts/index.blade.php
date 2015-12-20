@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
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

    <div class="modal fade" id="modal-custom-data">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['id'=>'form-create-contact','route'=>'contacts.store']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Contact custom info</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <a class="add-custom-field btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-plus"></span> Add custom field
                            </a>
                        </div>
                    </div>
                    <br>
                    <div id="custom-fields-container">
                        <div class="row">
                            <div class="col-xs-9 col-sm-10">
                                {{ Form::text('custom',null,['name'=>'customFields[]','class'=>'form-control']) }}
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a class="remove-custom-field btn btn-danger btn-sm" data-title="Delete" data-toggle="modal"
                                   data-target="#delete">
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
@extends('layouts.master')

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
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create contact</h4>
                </div>
                <div class="modal-body">
                    @include('contacts.partials.createUpdateForm')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
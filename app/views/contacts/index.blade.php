@extends('layouts.master')

@section('js')
    <script>

    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h2>Contact List</h2>
        </div>
        <div class="pull-right" style="margin-top:20px; margin-left:10px;">
            <button id="create-contact" class="btn btn-primary block-level"><span
                        class="glyphicon glyphicon-user"></span> Create Contact</button>
        </div>
        <div class="col-lg-4 pull-right">
            <input class="form-control" id="search" style="margin-top:20px" type="text" value="" placeholder="Search for Contacts">
        </div>
    </div>

    <hr>

    <div id="container-contact-list">
        @include('contacts.partials.list')
    </div>

    @include('contacts.partials.modals')
@stop
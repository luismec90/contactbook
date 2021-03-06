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
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
    {{ Form::email('phone',null,['class'=>'form-control']) }}
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <a class="add-custom-field btn btn-primary btn-sm" data-title="Edit" data-toggle="modal"
           data-target="#edit"><span
                    class="glyphicon glyphicon-plus"></span> Add custom field</a>
    </div>
</div>
<br>
<div id="custom-fields-container">
    <div class="row">
        <div class="col-xs-9 col-sm-10">
            {{ Form::text('custom',null,['name'=>'customFields[]','class'=>'form-control']) }}
        </div>
        <div class="col-xs-3 col-sm-2">
            <a class="remove-custom-field btn btn-danger btn-sm" data-title="Delete" data-toggle="modal" data-target="#delete">
                <span class="glyphicon glyphicon-trash"></span></a>
        </div>
    </div>
</div>
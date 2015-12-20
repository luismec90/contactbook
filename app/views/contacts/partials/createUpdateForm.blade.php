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


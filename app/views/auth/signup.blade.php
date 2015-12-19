@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="{{  route('login_path') }}">Log In</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="{{  route('signup_path') }}" class="active">Sign Up</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                {{ Form::open(['route' => ['signup_path'], 'method' => 'post','id'=>'register-form']) }}

                                <div class="form-group">
                                    {{Form::text('name', null,['class' => 'form-control','placeholder'=>'Name'])}}
                                </div>

                                <div class="form-group">
                                    {{Form::text('email', null,['class' => 'form-control','placeholder'=>'Email'])}}
                                </div>

                                <div class="form-group">
                                    {{Form::password('password',['class' => 'form-control','placeholder'=>'Password'])}}
                                </div>

                                <div class="form-group">
                                    {{Form::password('password_confirmation',['class' => 'form-control','placeholder'=>'Confirm password'])}}
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit"
                                                   tabindex="4" class="form-control btn btn-register"
                                                   value="Register Now">
                                        </div>
                                    </div>
                                </div>

                                {{ Form::close() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
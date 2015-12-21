@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/4.11.0/bootstrap-social.css">
@stop

@section('content')
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

                    @include('auth.partials.socialBtns')

                    <h3 class="text-muted text-center">OR</h3>
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
                                        <input type="submit" name="register-submit"
                                               tabindex="4" class="form-control btn btn-register"
                                               value="Sign Up">
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
@stop
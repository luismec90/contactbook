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
                            <a href="{{  route('login_path') }}" class="active">Log In</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="{{  route('signup_path') }}">Sign Up</a>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="panel-body">

                    @include('auth.partials.socialBtns')

                    <h3 class="text-muted text-center">OR</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::open(['route' => ['login_path'], 'method' => 'post','id'=>'login-form','style'=>'display: block;']) }}

                            <div class="form-group">
                                {{Form::email('email', null,['class' => 'form-control','placeholder'=>'Email','required'=>true])}}
                            </div>
                            <div class="form-group">
                                {{Form::password('password',['class' => 'form-control','placeholder'=>'Password','required'=>true])}}
                            </div>
                            <div class="form-group text-center">
                                <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                <label for="remember"> Remember Me</label>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input type="submit" name="login-submit" id="login-submit" tabindex="4"
                                               class="form-control btn btn-login" value="Log In">
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
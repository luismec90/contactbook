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
                    <div class="row">
                        <div class="col-sm-6">
                            <a class="btn btn-block btn-social btn-facebook" href="{{ route('facebook_path') }}">
                                <span class="fa fa-facebook"></span>Log in with Facebook
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <a class="btn btn-block btn-social btn-github" href="{{ route('github_path') }}">
                                <span class="fa fa-github"></span>Log in with Github
                            </a>
                        </div>
                    </div>

                    <h3 class="text-muted text-center">OR</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::open(['route' => ['login_path'], 'method' => 'post','id'=>'login-form','style'=>'display: block;']) }}

                            <div class="form-group">
                                <input type="email" name="email" id="email" tabindex="1"
                                       class="form-control" placeholder="Email" value="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" tabindex="2"
                                       class="form-control" placeholder="Password">
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
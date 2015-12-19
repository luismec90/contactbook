<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    protected $fillable = array('name', 'email');

    protected $hidden = array('password', 'remember_token');

    public static $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:4'
    ];

    public function contacts()
    {
        return $this->hasMany('Contact');
    }

}

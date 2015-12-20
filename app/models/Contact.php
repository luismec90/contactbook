<?php


class Contact extends Eloquent
{
    protected $fillable = array('name', 'surname', 'email', 'phone');

    public static $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];

    public function user()
    {
        return $this->belongsTo('User')->orderBy('name');
    }


    public function customData()
    {
        return $this->hasMany('CustomData');
    }

}

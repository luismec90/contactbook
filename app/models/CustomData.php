<?php


class CustomData extends Eloquent
{

    protected $table = 'custom_data';

    protected $fillable = array('content');

    public static $rules = [
        'content' => 'required',
    ];

    public function contact()
    {
        return $this->belongsTo('Contact');
    }

}

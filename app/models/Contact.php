<?php


class Contact extends Eloquent
{

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo('User')->orderBy('name');
    }


}

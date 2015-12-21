<?php

namespace App\Repositories;

use User;
use Contact;
use Hash;

class UserRepository
{
    public function create($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    public function firstOrCreate($data)
    {
        $user = User::firstOrNew(['email' => $data['email']]);
        if (!$user->id) {
            $user->name = $data['name'];
            $user->save();
        }
        return  $user;
    }

    public function update($data, $user)
    {
        return $user->update($data);
    }

}

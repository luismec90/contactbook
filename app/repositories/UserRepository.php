<?php

namespace App\Repositories;

use User;
use Contact;
use Hash;

class UserRepository
{

    public function findByFacebookID($facebookID)
    {
        return User::where('facebook_id', $facebookID)
            ->first();
    }

    public function findByGithubID($githubID)
    {
        return User::where('github_id', $githubID)
            ->first();
    }

    public function create($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    public function createWithFacebook($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->facebook_id = $data['id'];
        $user->save();
        return $user;
    }

    public function createWithGithub($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->github_id = $data['id'];
        $user->save();
        return $user;
    }


    public function update($data, $user)
    {
        return $user->update($data);
    }

}

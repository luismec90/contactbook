<?php

namespace App\Repositories;

use User;
use Contact;
use Hash;

class UserRepository
{

    /**
     * Find a user for the given Facebook ID.
     *
     * @param  string $facebookID
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByFacebookID($facebookID)
    {
        return User::where('facebook_id', $facebookID)
            ->first();
    }

    /**
     * Find a user for the given Github ID.
     *
     * @param  string $githubID
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByGithubID($githubID)
    {
        return User::where('github_id', $githubID)
            ->first();
    }

    /**
     * Handle the user data persistence.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    /**
     * Handle the user data persistence using data from Facebook.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createWithFacebook($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->facebook_id = $data['id'];
        $user->save();
        return $user;
    }

    /**
     * Handle the user data persistence using data from Github.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createWithGithub($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->github_id = $data['id'];
        $user->save();
        return $user;
    }

    /**
     * Handle the user data update.
     *
     * @param  array $data
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($data, $user)
    {
        return $user->update($data);
    }

}

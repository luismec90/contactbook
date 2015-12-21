<?php

namespace App\Repositories;

use User;
use Contact;

class ContactRepository
{
    public function getAll(User $user)
    {
        return $user->contacts()
            ->orderBy('name')
            ->get();
    }

    public function search($criteria, User $user)
    {
        return $user->contacts()
            ->where(function ($query) use ($criteria) {
                if ($criteria != '')
                    $query
                        ->orWhere('name', 'LIKE', "%$criteria%")
                        ->orWhere('surname', 'LIKE', "%$criteria%")
                        ->orWhere('email', 'LIKE', "%$criteria%")
                        ->orWhere('phone', 'LIKE', "%$criteria%");
            })->orderBy('name')
            ->get();
    }

    public function find($contactID, User $user)
    {
        return $user->contacts()
            ->find($contactID);
    }

    public function getByEmail($email, User $user)
    {
        return $user->contacts()
            ->where('email', $email)
            ->first();
    }

    public function save(Contact $contact, User $user)
    {
        return $user->contacts()->save($contact);
    }

    public function delete(Contact $contact)
    {
        return $contact->delete();
    }

    public function totalOtherContactsWithSameEmail($email, Contact $contact, User $user)
    {
        return $user
            ->contacts()
            ->where('email', $email)
            ->where('id', '<>', $contact->id)
            ->count();
    }
}
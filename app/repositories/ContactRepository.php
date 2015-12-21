<?php

namespace App\Repositories;

use User;
use Contact;

class ContactRepository
{
    /**
     * Get all of the contacts for the user.
     *
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(User $user)
    {
        return $user->contacts()
            ->orderBy('name')
            ->get();
    }

    /**
     * Search all contacts by name,surname,email and phone for the user using the give criteria.
     *
     * @param  String $criteria
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
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

    /**
     * Find a contact for the user using the given contact ID.
     *
     * @param  int $contactID
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($contactID, User $user)
    {
        return $user->contacts()
            ->find($contactID);
    }

    /**
     * Find a contact for the user using the given email.
     *
     * @param  String $email
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getByEmail($email, User $user)
    {
        return $user->contacts()
            ->where('email', $email)
            ->first();
    }

    /**
     * Handle the contact data persistence.
     *
     * @param  Contact $contact
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(Contact $contact, User $user)
    {
        return $user->contacts()->save($contact);
    }

    /**
     * Handle the contact delete.
     *
     * @param  Contact $contact
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete(Contact $contact)
    {
        return $contact->delete();
    }

    /**
     * Get the number of contacts who have the same email ignoring the given contact ID.
     *
     * @param  Contact $contact
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function totalOtherContactsWithSameEmail($email, Contact $contact, User $user)
    {
        return $user
            ->contacts()
            ->where('email', $email)
            ->where('id', '<>', $contact->id)
            ->count();
    }
}

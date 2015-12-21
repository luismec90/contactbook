<?php

namespace App\Repositories;

use Contact;
use CustomData;

class CustomDataRepository
{

    /**
     * Get all the custom data for the contact.
     *
     * @param  Contact $contact
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forContact(Contact $contact)
    {
        return $contact->customData;
    }

    /**
     * Synchronize the custom data for the contact
     *
     * @param  array $input
     * @param  Contact $contact
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function sync($input, Contact $contact)
    {
        $customData = [];

        foreach ($input as $content) {
            if (strlen($content)) {
                $customData[] = new CustomData(['content' => $content]);
            }
        }

        $contact->customData()->delete();

        return $contact->customData()->saveMany($customData);
    }

}

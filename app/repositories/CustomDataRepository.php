<?php

namespace App\Repositories;

use Contact;
use CustomData;

class CustomDataRepository
{

    public function forContact(Contact $contact)
    {
        return $contact->customData;
    }

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

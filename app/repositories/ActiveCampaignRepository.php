<?php

namespace App\Repositories;

use ActiveCampaign;
use Contact;

class ActiveCampaignRepository
{
    private $activeCampaignApiURL = "https://luisfer.api-us1.com";
    private $activeCampaignApiKey = "af258ef86abbc89fcbeab50a4bc75b97deb7e0486d7d1f355e9b4462871244ce8307f659";

    public function sync(Contact $contact, $status)
    {
        $ac = new ActiveCampaign($this->activeCampaignApiURL, $this->activeCampaignApiKey);

        $customData = $contact->customData;

        $data = [
            'email' => $contact->email,
            'first_name' => $contact->name,
            'last_name' => $contact->surname,
            'phone' => $contact->phone,
            'p[1]' => 1,
            'status[1]' => $status,
            'field[1,0]' => isset($customData[0]) ? $customData[0] : '',
            'field[2,0]' => isset($customData[1]) ? $customData[1] : '',
            'field[3,0]' => isset($customData[2]) ? $customData[2] : '',
            'field[4,0]' => isset($customData[3]) ? $customData[3] : '',
            'field[5,0]' => isset($customData[4]) ? $customData[4] : '',
        ];

        return $ac->api("contact/sync", $data);
    }


}

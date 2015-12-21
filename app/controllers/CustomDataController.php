<?php

use App\Repositories\ContactRepository;
use App\Repositories\CustomDataRepository;
use App\Repositories\ActiveCampaignRepository;

class CustomDataController extends BaseController
{

    protected $contacts;
    protected $customData;

    public function __construct(ContactRepository $contacts, CustomDataRepository $customData,ActiveCampaignRepository $activeCampaign)
    {
        $this->contacts = $contacts;
        $this->customData = $customData;
        $this->activeCampaign = $activeCampaign;
    }

    public function show($contactID)
    {
        $contact = $this->contacts->find($contactID, Auth::user());

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        return Response::json(['data' => $this->customData->forContact($contact)]);
    }


    public function update($contactID)
    {
        $contact = $this->contacts->find($contactID, Auth::user());

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        if (!is_array(Input::get('customData'))) {
            return Response::json(['errors' => ['Invalid data format.']], 422);
        }

        $this->customData->sync(Input::get('customData'), $contact);

        $this->activeCampaign->sync($contact, 1);

        return Response::json();
    }
}
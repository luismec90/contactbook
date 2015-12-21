<?php

use App\Repositories\ContactRepository;
use App\Repositories\CustomDataRepository;
use App\Repositories\ActiveCampaignRepository;

class CustomDataController extends BaseController
{
    /**
     * The contact repository instance.
     *
     * @var App\Repositories\ContactRepository;
     */
    protected $contacts;

    /**
     * The custom data repository instance.
     *
     * @var App\Repositories\CustomDataRepository;
     */
    protected $customData;


    /**
     * Create a new custom data controller instance.
     *
     * @param  App\Repositories\ContactRepository $contacts
     * @param  App\Repositories\CustomDataRepository $customData
     * @param  App\Repositories\ActiveCampaignRepository $activeCampaign
     * @return void
     */
    public function __construct(ContactRepository $contacts, CustomDataRepository $customData, ActiveCampaignRepository $activeCampaign)
    {
        $this->contacts = $contacts;
        $this->customData = $customData;
        $this->activeCampaign = $activeCampaign;
    }

    /**
     * Get the custom data for the given contact ID.
     *
     * @param  int $contactID
     * @return \Illuminate\Http\Response
     */
    public function show($contactID)
    {
        $contact = $this->contacts->find($contactID, Auth::user());
        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        return Response::json(['data' => $this->customData->forContact($contact)]);
    }

    /**
     * Handle a  custom data update for the given contact ID.
     *
     * @param  int $contactID
     * @return \Illuminate\Http\Response
     */
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

        return Response::json(['message' => 'Custom fields updated.']);
    }
}
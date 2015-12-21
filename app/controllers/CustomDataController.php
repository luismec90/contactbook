<?php

use App\Repositories\ContactRepository;
use App\Repositories\CustomDataRepository;

class CustomDataController extends BaseController
{
    protected $contacts;
    protected $customData;

    public function __construct(ContactRepository $contacts, CustomDataRepository $customData)
    {
        $this->contacts = $contacts;
        $this->customData = $customData;
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

        $this->customData->syncData(Input::get('customData'),$contact);

        return Response::json();
    }
}
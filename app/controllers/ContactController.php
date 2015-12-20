<?php

class ContactController extends BaseController
{
    private $activeCampaignURL = "https://luisfer.api-us1.com";
    private $activeCampaignApiKey = "af258ef86abbc89fcbeab50a4bc75b97deb7e0486d7d1f355e9b4462871244ce8307f659";

    public function index()
    {
        $contacts = Auth::user()
            ->contacts()
            ->get();

        return View::make('contacts.index', compact('contacts'));
    }

    public function show($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        return Response::json(['data' => $contact]);
    }

    public function showCustomData($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        return Response::json(['data' => $contact->customData]);
    }

    public function store()
    {
        $validator = Validator::make(Input::all(), Contact::$rules);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 422);
        }

        $contact = Auth::user()
            ->contacts()
            ->where('email', Input::get('email'))
            ->first();

        if (!is_null($contact)) {
            return Response::json(['errors' => ['email' => 'The email has already been taken.']], 422);
        }

        $contact = new Contact(Input::all());
        Auth::user()->contacts()->save($contact);
        $this->syncContactActiveCampaign($contact, 1);

        return Response::json(['data' => $contact]);
    }

    public function update($contactID)
    {
        $validator = Validator::make(Input::all(), Contact::$rules);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 422);
        }

        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        $totalEmailUses = Auth::user()
            ->contacts()
            ->where('email', Input::get('email'))
            ->where('id', '<>', $contact->id)
            ->count();

        if ($totalEmailUses > 0) {
            return Response::json(['errors' => ['The email belongs to another user.']], 422);
        }

        $contact->update(Input::all());
        $this->syncContactActiveCampaign($contact, 1);

        return Response::json(['data' => $contact]);
    }

    public function destroy($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        $contact->delete();
        $this->syncContactActiveCampaign($contact, 2);

        return Response::json(['data' => $contact]);
    }

    private function syncContactActiveCampaign($contact, $status)
    {
        $ac = new ActiveCampaign($this->activeCampaignURL, $this->activeCampaignApiKey);
        $data = array(
            'email' => $contact->email,
            'first_name' => $contact->name,
            'last_name' => $contact->surname,
            'phone' => $contact->phone,
            'p[1]' => 1,
            'status[1]' => $status,
        );
        $ac->api("contact/sync", $data);
    }
}
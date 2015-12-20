<?php

class ContactController extends BaseController
{
    private $activeCamapingURL = "https://luisfer.api-us1.com";
    private $activeCamapingApiKey = "af258ef86abbc89fcbeab50a4bc75b97deb7e0486d7d1f355e9b4462871244ce8307f659";

    public function index()
    {
        $contacts = Auth::user()
            ->contacts()
            ->get();

        return View::make('contacts.index', compact('contacts'));
    }

    public function store()
    {
        $validator = Validator::make(Input::all(), Contact::$rules);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->toArray()], 422);
        }

        $contact = new Contact(Input::all());

        Auth::user()->contacts()->save($contact);

        $ac = new ActiveCampaign($this->activeCamapingURL, $this->activeCamapingApiKey);

        $c = array(
            'email' => $contact->email,
            'first_name' => $contact->name,
            'last_name' => $contact->surname,
            'phone' => $contact->phone,
            'p[1]' => 1,
            'status[1]' => 1,
        );

        $ac->api("contact/sync", $c);

        return Response::json(['status' => 'ok','contact'=>$contact]);
    }

    public function update($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        $contact->update(Input::all());

        return Response::json('ok', 200);
    }

    public function destroy($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        $contactID = $contact->id;
        $contactEmail = $contact->email;

        $contact->delete();

        $ac = new ActiveCampaign($this->activeCamapingURL, $this->activeCamapingApiKey);

        $contact = [
            'email' => $contactEmail,
            'p[1]' => 1,
            'status[1]' => 2,
        ];

        $ac->api("contact/sync", $contact);

        return Response::json(['status' => 'ok', 'contactID' =>$contactID]);

    }
}
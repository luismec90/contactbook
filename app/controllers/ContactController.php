<?php

use App\Repositories\ContactRepository;

class ContactController extends BaseController
{
    private $activeCampaignApiURL = "https://luisfer.api-us1.com";
    private $activeCampaignApiKey = "af258ef86abbc89fcbeab50a4bc75b97deb7e0486d7d1f355e9b4462871244ce8307f659";

    protected $contacts;

    public function __construct(ContactRepository $contacts)
    {
        $this->contacts = $contacts;
    }

    public function index()
    {
        $contacts = $this->contacts->getAll(Auth::user());

        if (Request::ajax()) {
            $query = View::make('contacts.partials.list', compact('contacts'))->render();
            return Response::json(['data' => $query]);
        } else {
            return View::make('contacts.index', compact('contacts'));
        }

    }

    public function search($criteria = '')
    {
        $contacts = $this->contacts->search($criteria, Auth::user());

        $query = View::make('contacts.partials.list', compact('contacts'))->render();
        return Response::json(['data' => $query]);
    }

    public function show($contactID)
    {
        $contact = $this->contacts->find($contactID, Auth::user());
        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }
        return Response::json(['data' => $contact]);
    }

    public function store()
    {
        $validator = Validator::make(Input::all(), Contact::$rules);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 422);
        }

        $contact = $this->contacts->getByEmail(Input::get('email'), Auth::user());

        if (!is_null($contact)) {
            return Response::json(['errors' => ['email' => 'The email has already been taken.']], 422);
        }

        $contact = new Contact(Input::all());
        $this->contacts->save($contact, Auth::user());
        $this->syncContactActiveCampaign($contact, 1);

        return Response::json(['data' => $contact]);
    }

    public function update($contactID)
    {
        $validator = Validator::make(Input::all(), Contact::$rules);
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 422);
        }
        $contact = $this->contacts->find($contactID, Auth::user());
        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }
        $totalOtherContactsWithSameEmail = $this->contacts->totalOtherContactsWithSameEmail(Input::get('email'), $contact, Auth::user());
        if ($totalOtherContactsWithSameEmail > 0) {
            return Response::json(['errors' => ['The email belongs to another user.']], 422);
        }
        $contact->update(Input::all());
        $this->syncContactActiveCampaign($contact, 1);

        return Response::json(['data' => $contact]);
    }

    public function destroy($contactID)
    {
        $contact = $this->contacts->find($contactID, Auth::user());
        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }
        $this->contacts->delete($contact);
        $this->syncContactActiveCampaign($contact, 2);

        return Response::json(['data' => $contact]);
    }

    private function syncContactActiveCampaign($contact, $status)
    {
        $ac = new ActiveCampaign($this->activeCampaignApiURL, $this->activeCampaignApiKey);
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
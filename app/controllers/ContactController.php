<?php

use App\Repositories\ContactRepository;
use App\Repositories\ActiveCampaignRepository;

class ContactController extends BaseController
{
    protected $contacts;
    protected $activeCampaign;

    public function __construct(ContactRepository $contacts, ActiveCampaignRepository $activeCampaign)
    {
        $this->contacts = $contacts;
        $this->activeCampaign = $activeCampaign;
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

        $this->activeCampaign->sync($contact, 1);

        return Response::json(['data' => []]);
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

        $this->activeCampaign->sync($contact, 1);

        return Response::json(['data' => []]);
    }

    public function destroy($contactID)
    {
        $contact = $this->contacts->find($contactID, Auth::user());
        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }
        $this->contacts->delete($contact);

        $this->activeCampaign->sync($contact, 2);

        return Response::json(['data' => []]);
    }
}
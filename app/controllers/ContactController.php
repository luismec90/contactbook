<?php

class ContactController extends BaseController
{
    public function index()
    {
        $contacts = Auth::user()
            ->contacts()
            ->get();

        return View::make('contacts.index', compact('contacts'));
    }

    public function store()
    {
        $contact = new Conctact(Input::all());

        Auth::user()->save($contact);

        return Response::json('ok', 200);
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

        $contact->delete();

        return Response::json('ok', 200);
    }
}
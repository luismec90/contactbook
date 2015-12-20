<?php

class CustomDataController extends BaseController
{

    public function show($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        return Response::json($contact->customData);
    }


    public function update($contactID)
    {
        $contact = Auth::user()
            ->contacts()
            ->find($contactID);

        if (is_null($contact)) {
            return Response::json(['errors' => ['The contact does not exist.']], 422);
        }

        $contact->customData()->sync(Input::get('customData'));

        return Response::json([]);
    }
}
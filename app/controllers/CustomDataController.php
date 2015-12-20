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

        $customData = [];

        if (is_array(Input::get('customData'))) {
            foreach (Input::get('customData') as $content) {
                if (strlen($content)) {
                    $customData[] = new CustomData(['content' => $content]);
                }
            }
        }

        $contact->customData()->delete();
        $contact->customData()->saveMany($customData);

        return Response::json([]);
    }
}
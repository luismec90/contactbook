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
}
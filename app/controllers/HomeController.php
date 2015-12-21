<?php

class HomeController extends BaseController
{
    /**
     * Redirect to the contact list.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return Redirect::route('contacts.index');
    }
}

<?php

class ContactController extends BaseController
{
    public function index()
    {
        return View::make('contacts.index');
    }
}
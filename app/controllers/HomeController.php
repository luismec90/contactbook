<?php

class HomeController extends BaseController
{

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function index()
    {
        return Redirect::route('contacts.index');

        $ac = new ActiveCampaign("https://luisfer.api-us1.com", "af258ef86abbc89fcbeab50a4bc75b97deb7e0486d7d1f355e9b4462871244ce8307f659");

        if (!(int)$ac->credentials_test()) {
            echo "<p>Access denied: Invalid credentials (URL and/or API key).</p>";
            exit();
        }

        echo "<p>Credentials valid! Proceeding...</p>";

        $contact = array(
            "id" => "2",
        );
        var_dump($contact);
        $ac->verb = 'GET';
        $contact_sync = $ac->api("contact/delete?id=2");

        dd($contact_sync);


        //
    }

}

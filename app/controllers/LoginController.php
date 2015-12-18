<?php

class LoginController extends BaseController
{

    public function index()
    {
        return View::make('login');
    }

    public function loginWithGithub()
    {

        // get data from input
        $code = Input::get('code');

        // get fb service
        $gh = OAuth::consumer('Github');

        // check if code is valid

        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from facebook, get the token
            $gh->requestAccessToken($code);

            // Send a request with it

            $result = json_decode($gh->request('user/emails'), true);
            echo 'The first email on your github account is ' . $result[0];

            //Var_dump
            //display whole array().
            dd($result);

        } // if not ask for permission first
        else {
            // get fb authorization
            $url = $gh->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to((string)$url);
        }
    }

    public function githubResponse()
    {

    }
}

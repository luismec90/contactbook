<?php

use App\Repositories\UserRepository;

class AuthController extends BaseController
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function showLogin()
    {
        return View::make('auth.login');
    }

    public function postLogin()
    {
        $data = ['email' => Input::get('email'),
            'password' => Input::get('password')];

        if (Auth::attempt($data, Input::get('remember'))) {
            return Redirect::intended('/');
        }

        return Redirect::back()->withErrors(['Email or password incorrect!'])->withInput();
    }

    public function showSignup()
    {
        return View::make('auth.signup');
    }

    public function postSignup()
    {
        $validation = Validator::make(Input::all(), User::$rules);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $user = $this->user->create(Input::all());

        Auth::login($user);

        return Redirect::route('contacts.index');
    }

    public function logout()
    {
        Auth::logout();

        return Redirect::route('login_path');
    }


    public function github()
    {
        // get data from input
        $code = Input::get('code');

        // get gh service
        $gh = OAuth::consumer('GitHub');

        // check if code is valid

        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from facebook, get the token
            $gh->requestAccessToken($code);

            $result = json_decode($gh->request('user'), true);

            $user = $this->users->firstOrCrate($result);

            Auth::login($user);

            return Redirect::route('contacts.index');
        } // if not ask for permission first
        else {
            // get fb authorization
            $url = $gh->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to((string)$url);
        }
    }

    public function facebook()
    {
        // get data from input
        $code = Input::get('code');

        // get fb service
        $fb = OAuth::consumer('Facebook');

        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($fb->request('/me?fields=name,email'), true);

            $user = $this->users->firstOrCrate($result);

            Auth::login($user);

            return Redirect::route('contacts.index');

        } // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to((string)$url);
        }
    }
}
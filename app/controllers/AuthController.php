<?php

use App\Repositories\UserRepository;

class AuthController extends BaseController
{

    /**
     * The user repository instance.
     *
     * @var App\Repositories\UserRepository;
     */
    protected $users;

    /**
     * Create a new authentication controller instance.
     *
     * @param  App\Repositories\UserRepository $users
     * @return void
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Show the application log in form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return View::make('auth.login');
    }

    /**
     * Handle a log in request for the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
        $data = ['email' => Input::get('email'),
            'password' => Input::get('password')];
        if (Auth::attempt($data, Input::get('remember'))) {
            return Redirect::intended('/');
        }

        return Redirect::back()->withErrors(['Invalid email or password.'])->withInput();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSignup()
    {
        return View::make('auth.signup');
    }

    /**
     * Handle a sign un request for the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSignup()
    {
        $validation = Validator::make(Input::all(), User::$rules);
        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation);
        }

        $user = $this->users->create(Input::all());
        Auth::login($user);

        return Redirect::route('contacts.index');
    }

    /**
     * Handle a log out request for the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::route('login_path');
    }

    /**
     * Handle the Facebook log in/sign up.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

            $user = $this->users->findByFacebookID($result['id']);

            if (!$user) {
                $user = $this->users->createWithFacebook($result);
            }

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

    /**
     * Handle the Github log in/sign up.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

            $user = $this->users->findByGithubID($result['id']);

            if (!$user) {
                $user = $this->users->createWithGithub($result);
            }

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
}
<?php

use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{

    public function showLogin()
    {
        // Verificamos si hay sesión activa
        if (Auth::check()) {
            // Si tenemos sesión activa mostrará la página de inicio
            return Redirect::to('/');
        }
        // Si no hay sesión activa mostramos el formulario
        return View::make('login');
    }

    public function postLogin()
    {

        // Obtenemos los datos del formulario
        $data = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        // Verificamos los datos
        if (Auth::attempt($data, Input::get('remember'))) // Como segundo parámetro pasámos el checkbox para sabes si queremos recordar la contraseña
        {
            // Si nuestros datos son correctos mostramos la página de inicio
            return Redirect::intended('/');

            dd(Input::all());
        }
        // Si los datos no son los correctos volvemos al login y mostramos un error
        return Redirect::back()->withErrors(['Email or password incorrect!'])->withInput();
    }

    public function logOut()
    {
        Auth::logout();

        return Redirect::to('login')->with('error_message', 'Logged out correctly');
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

            // Send a request with it

            $result = json_decode($gh->request('user'), true);


            return $result;

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

        // check if code is valid

        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($fb->request('/me'), true);

            $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message . "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        } // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to((string)$url);
        }
    }
}
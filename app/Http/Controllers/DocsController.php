<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
    	return view('docs.index', []);
    }

    public function apiRef() {

        $setupRoutes = [];
        $authRoutes = [];

        $authRoutes[] = array(
            'label' => 'login',
            'name' => 'login',
            'path' => '/api/auth/login',
            'status_expected' => 200,
            'method' => 'POST',
            'description' => 'allows the user to login to their account. if credentials are correct, an access token is returned and should be saved in some way to use for future requests',
            'payload' => array(
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ),
            'returns' => array(
                'access_token' => 'string',
                'token_type' => 'string',
                'expires_at' => 'datetime'
            )
        );

        // user
        $authRoutes[] = array(
            'label' => 'user',
            'name' => 'user',
            'path' => '/api/auth/user',
            'status_expected' => 200,
            'method' => 'GET',
            'description' => 'gets the logged in user',
            'payload' => array(
                
            ),
            'returns' => array(
                'user' => 'Object'
            )
        );

        // logout
        $authRoutes[] = array(
            'label' => 'logout',
            'name' => 'login',
            'path' => '/api/auth/logout',
            'status_expected' => 200,
            'method' => 'GET',
            'description' => 'revokes the users token and logs the user out',
            'payload' => array(
                
            ),
            'returns' => array(
                'message' => 'String|Successfully logged out'
            )
        );

        $setupRoutes[] = array(
            'label' => 'signup',
            'name' => 'signup',
            'path' => '/api/auth/signup',
            'status_expected' => 201,
            'method' => 'POST',
            'description' => 'allows the user to create an account and sends the user a verification email',
            'payload' => array(
                'name' => 'required | string',
                'email' => 'required | string | email',
                'phone_number' => 'optional | string',
                'avatar' => 'optional | string | file path',
                'password' => 'required | string',
                'password_confirmation' => 'required | string'
            ),
            'returns' => array(
                'message' => 'a message describing the response',
                'access_token' => 'a token to be used to authenicate the user',
                'token_type' => 'Bearer',
                'expires_at' => 'datetime string of when the token expires'
            )
        );

        $features = [];

        $features[] = array(
            'label' => 'Authentication',
            'name' => 'authentication',
            'description' => 'The following endpoints deal with authentication related actions. All protected routes need to include a Bearer token in the header. The Bearer token can be found in the response of login. Example header "Authorization: Bearer {access_token}"',
            'routes' => $authRoutes
        );

        $features[] = array(
            'label' => 'Setup',
            'name' => 'setup',
            'description' => 'This is where the setup ',
            'routes' => $setupRoutes
        );

        // $features[] = array(
        //     'label' => 'Calander',
        //     'name' => 'calander',
        //     'description' => '',
        //     'routes' => []
        // );

        // $features[] = array(
        //     'label' => 'Set Lists',
        //     'name' => 'set-lists',
        //     'description' => '',
        //     'routes' => []
        // );

    	return view('docs.api_ref', ['features' => $features]);
    }

    public function dbSchema() {
    	return view('docs.schema', []);
    }
}

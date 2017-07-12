<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function signUp(Request $request)
    {
    	$rules = array('Email' => 'unique:Hair_Stylist,Email');
		$validator = Validator::make(array("Email" => $request->input('email')), $rules);

        if ($validator->fails()) {
        	return response()->json(['status' => 409, 'msg' => 'That email address is already registered'], 200);
        }

        $user = User::create([
        	'First_Name' => $request->input('firstname'),
        	'Surname' => $request->input('lastname'),
            'Email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'Mobile_Number' => $request->input('phone'),
            'subscription_updates' => $request->input('subscription_updates'),
            'activation_token' => md5($request->input('email') . microtime()),
            'activated' => true
        ]);
		   
    	return response()->json(['status' => 200, 'msg' => 'Success'], 200);
    }

    public function signIn(Request $request)
    {
    	$email = $request->input('email');
    	$password = $request->input('password');
    	$remember = $request->input('remember');
    	if (Auth::attempt(['Email' => $email, 'password' => $password], $remember)) {
		    $token = csrf_token();
		    $user = Auth::user();
		    $data = array(
				"user" => $user,
				"token" => $token
			);
		    return response()->json(['status' => 200, 'msg' => 'Success', 'data' => $data], 200);
		}else {
        	return response()->json(['status' => 401, 'msg' => 'Unauthorized', 'data' => "Invalid username / password"], 200);
        }
    }

    public function signOut(Request $request)
    {
    	Auth::logout();
    	return response()->json(['status' => 200, 'msg' => 'Success'], 200);
    }

    public function verifyToken($token, Request $request)
    {
        User::where('activation_token', $token) -> update(["activated" => true]);
        return response()->json(['status' => 200, 'msg' => 'Success'], 200);
    }
}

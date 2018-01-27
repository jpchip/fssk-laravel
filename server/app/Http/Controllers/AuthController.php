<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

	/**
	 * Log in
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$validatedData = $request->validate([
			'email' => 'required',
			'password' => 'required',
		]);

		$input = $request->all();

		if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
			// Authentication passed...
		}
	}

	/**
	 * Log out
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{

	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{

	/**
	 * Log in
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$input = $request->all();
		$validator = Validator::make($input, [
			'email' => 'required',
			'password' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['error' => 'missing required field.'], 400);
		}


		if (Auth::guard('api')->attempt(['email' => $input['email'], 'password' => $input['password']])) {
			return response()->json(Auth::guard('api')->user());
		}

		return response()->json(['error' => 'log in failed.'], 401);
	}

	/**
	 * Log out
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		Auth::guard('api')->logout();
	}
}

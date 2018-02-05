<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		if(Auth::user()->is_admin) {
			return User::all();
		}
		return response()->json(['error' => 'Must be Admin.'], 401);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:10',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$data = $request->all();
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);

		return response()->json($user, 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		$activeUser = Auth::guard('api')->user();
		if($user->id != $activeUser->id) {
			if(!$activeUser->is_admin) {
				return response()->json(['error' => 'Must be Admin.'], 401);
			}
		}
		return response()->json($user);
	}

	/**
	 * Display the todos associated with resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function showTodos(User $user)
	{
		$activeUser = Auth::guard('api')->user();
		if($user->id != $activeUser->id) {
			if(!$activeUser->is_admin) {
				return response()->json(['error' => 'Must be Admin.'], 401);
			}
		}
		return response()->json($user->todos);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$user->update($request->all());

		return response()->json($user, 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @throws \Exception
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		if(Auth::user()->is_admin) {
			$user->delete();
			return response()->json(null, 204);
		}
		return response()->json(['error' => 'Must be Admin.'], 401);
	}
}

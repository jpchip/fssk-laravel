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
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('all', User::class);
		return User::all();
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
			'password' => 'required|string',
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
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		$this->authorize('view', $user);
		return response()->json($user);
	}

	/**
	 * Display the todos associated with resource.
	 *
	 * @param  \App\User  $user
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @return \Illuminate\Http\Response
	 */
	public function showTodos(User $user)
	{
		$this->authorize('view', $user);
		return response()->json($user->todos);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$this->authorize('update', $user);
		$user->update($request->all());
		return response()->json($user, 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \Exception
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$this->authorize('delete', $user);
		$user->delete();
		return response()->json(null, 204);
	}
}

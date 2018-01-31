<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TodoController extends Controller
{
	/**
	 * Returns all todos if current user is admin, otherwise
	 * just list of todos the current user has ownership of.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = Auth::user();
		if($user->is_admin) {
			return Todo::all();
		}
		return response()->json($user->todos);
	}

	/**
	 * Creates new Todo
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'user_id' => ['required', Rule::in([Auth::id()])],
			'completed' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$todo = Todo::create($request->all());
		return response()->json($todo, 201);
	}

	/**
	 * Returns single Todo
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function show(Todo $todo)
	{
		return response()->json($todo);
	}

	/**
	 * Updates Todo
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Todo $todo)
	{
		$todo->update($request->all());

		return response()->json($todo, 200);
	}

	/**
	 * Deletes Todo
	 * @param  \App\Todo  $todo
	 * @throws \Exception
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Todo $todo)
	{
		$todo->delete();
		return response()->json(null, 204);
	}
}

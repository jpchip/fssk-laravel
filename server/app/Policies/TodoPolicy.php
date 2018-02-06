<?php

namespace App\Policies;

use App\User;
use App\Todo;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
	use HandlesAuthorization;

	/**
	 * @param \App\User $user
	 * @param $ability
	 * @return bool
	 */
	public function before($user, $ability)
	{
		if ($user->is_admin) {
			return true;
		}
	}

	/**
	 * Determine whether the user can view all models
	 *
	 * @param  \App\User  $user
	 * @return bool
	 */
	public function all(User $user)
	{
		return true;
	}


	/**
	 * Determine whether the user can view the todo.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return mixed
	 */
	public function view(User $user, Todo $todo)
	{
		return $user->id == $todo->user_id || $user->is_admin;
	}

	/**
	 * Determine whether the user can create todos.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		return true;
	}

	/**
	 * Determine whether the user can update the todo.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return mixed
	 */
	public function update(User $user, Todo $todo)
	{
		return $user->id == $todo->user_id || $user->is_admin;
	}

	/**
	 * Determine whether the user can delete the todo.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return mixed
	 */
	public function delete(User $user, Todo $todo)
	{
		return $user->id == $todo->user_id || $user->is_admin;
	}
}

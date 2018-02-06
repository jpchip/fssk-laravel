<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
		return $user->is_admin;
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\User  $user
	 * @param  \App\User  $model
	 * @return bool
	 */
	public function view(User $user, User $model)
	{
		return $user->id == $model->id || $user->is_admin;
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\User  $user
	 * @return bool
	 */
	public function create(User $user)
	{
		return true;
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\User  $user
	 * @param  \App\User  $model
	 * @return bool
	 */
	public function update(User $user, User $model)
	{
		return $user->id == $model->id || ($user->is_admin && !$model->is_admin);
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\User  $user
	 * @param  \App\User  $model
	 * @return bool
	 */
	public function delete(User $user, User $model)
	{
		return $user->is_admin;
	}
}

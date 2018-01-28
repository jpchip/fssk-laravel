<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	use Uuids;

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	public function user()
	{
		return $this->hasOne('App\User');
	}
}

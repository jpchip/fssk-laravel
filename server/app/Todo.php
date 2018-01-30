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

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'user_id', 'completed', 'order'
	];

	public function user()
	{
		return $this->hasOne('App\User');
	}
}

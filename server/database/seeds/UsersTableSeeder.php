<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->insert([
			'id' => "52bd60d3-fde7-4625-bc1f-2ea2e2288072",
			'name' => 'Testy McTesterson',
			'email' => 'test@earthlinginteractive.com',
			'password' => bcrypt('test'),
			'is_admin' => false
		]);
	}
}

<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('todos')->insert([
			'title' => 'test',
			'user_id' => '52bd60d3-fde7-4625-bc1f-2ea2e2288072',
			'order' => 1,
			'completed' => false
		]);
	}
}

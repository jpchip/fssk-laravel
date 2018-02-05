<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
	return [
		'title' => $faker->sentence,
		'user_id' => '52bd60d3-fde7-4625-bc1f-2ea2e2288072',
		'order' => '1',
		'completed' => false
	];
});

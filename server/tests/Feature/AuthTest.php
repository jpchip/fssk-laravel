<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	public function testIndex()
	{
		$response = $this->json('GET', '/api/auth');

		$response
			->assertStatus(200)
			->assertJson(['user' => false]);
	}

	public function testIndexWhenLoggedIn()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/auth');

		$response
			->assertStatus(200)
			->assertJson(['user' => $user->toArray()]);
	}
}

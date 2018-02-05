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

	public function testLoginWithMissingParams()
	{
		$response = $this->json('POST', '/api/auth');

		$response
			->assertStatus(400)
			->assertJson(['error' => 'missing required field.']);
	}

	public function testLoginWithInvalidParams()
	{
		$response = $this->json('POST', '/api/auth', ['email' => 'junk@example.com', 'password' => 'junk']);

		$response
			->assertStatus(401)
			->assertJson(['error' => 'log in failed.']);
	}

	public function testLoginWithValidParams()
	{
		$user = factory(User::class)->create();
		$response = $this->json('POST', '/api/auth', ['email' => $user->email, 'password' => 'secret']);

		$this->assertAuthenticated('api');

		$response
			->assertStatus(200)
			->assertJson($user->toArray());
	}

	public function testLogout()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('DELETE', '/api/auth');

		$response
			->assertStatus(204);
	}
}

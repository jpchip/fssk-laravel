<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	protected $baseUrl = '/api/auth';

	public function testIndex()
	{
		$response = $this->json('GET', $this->baseUrl);

		$response
			->assertStatus(200)
			->assertJson(['user' => false]);
	}

	public function testIndexWhenLoggedIn()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl);

		$response
			->assertStatus(200)
			->assertJson(['user' => $user->toArray()]);
	}

	public function testRegisterWithMissingParams()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('POST', $this->baseUrl . '/register');

		$response
			->assertStatus(400);
	}

	public function testRegisterWithValidParams()
	{
		$user = factory(User::class)->make();
		$response = $this->json('POST', $this->baseUrl . '/register', ['name' => $user->name, 'email' => $user->email, 'password' => 'secret']);

		$response
			->assertStatus(201)
			->assertJson(['user' => ['name' => $user->name, 'email' => $user->email]]);
	}

	public function testLoginWithMissingParams()
	{
		$response = $this->json('POST', $this->baseUrl);

		$response
			->assertStatus(400)
			->assertJson(['error' => 'missing required field.']);
	}

	public function testLoginWithInvalidParams()
	{
		$response = $this->json('POST', $this->baseUrl, ['email' => 'junk@example.com', 'password' => 'junk']);

		$response
			->assertStatus(401)
			->assertJson(['error' => 'log in failed.']);
	}

	public function testLoginWithValidParams()
	{
		$user = factory(User::class)->create();
		$response = $this->json('POST', $this->baseUrl, ['email' => $user->email, 'password' => 'secret']);

		$this->assertAuthenticated('api');

		$response
			->assertStatus(200)
			->assertJson($user->toArray());
	}

	public function testLogout()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('DELETE', $this->baseUrl);

		$response
			->assertStatus(204);
	}
}

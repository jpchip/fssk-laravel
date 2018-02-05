<?php

namespace Tests\Feature;

use App\User;
use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

	use RefreshDatabase;

	public function testIndex()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users');

		$response
			->assertStatus(401)
			->assertJson(['error' => 'Must be Admin.']);
	}

	public function testIndexAsAdmin()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users');

		$response
			->assertStatus(200)
			->assertJson([$user->toArray()]);
	}

	public function testShow()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users/' . $user->id);

		$response
			->assertStatus(200)
			->assertJson($user->toArray());
	}

	public function testShowWithoutAdmin()
	{
		$user = factory(User::class)->create();
		$anotherUser = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users/' . $anotherUser->id);

		$response
			->assertStatus(401)
			->assertJson(['error' => 'Must be Admin.']);
	}

	public function testShowWithAdmin()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$anotherUser = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users/' . $anotherUser->id);

		$response
			->assertStatus(200)
			->assertJson($anotherUser->toArray());
	}

	public function testShowTodos()
	{
		$user = factory(User::class)->create();
		$todo = factory(Todo::class)->create([
			'user_id' => $user->id
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users/' . $user->id . '/todos');

		$response
			->assertStatus(200)
			->assertJson([$todo->toArray()]);
	}

	public function testShowTodosWithoutAdmin()
	{
		$user = factory(User::class)->create();
		$anotherUser = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users/' . $anotherUser->id . '/todos');

		$response
			->assertStatus(401)
			->assertJson(['error' => 'Must be Admin.']);
	}

	public function testShowTodosWithAdmin()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$anotherUser = factory(User::class)->create();
		$todo = factory(Todo::class)->create([
			'user_id' => $anotherUser->id
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', '/api/users/' . $anotherUser->id . '/todos');

		$response
			->assertStatus(200)
			->assertJson([$todo->toArray()]);
	}
}

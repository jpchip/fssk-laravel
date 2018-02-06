<?php

namespace Tests\Feature;

use App\User;
use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

	use RefreshDatabase;

	protected $baseUrl = '/api/users';

	public function testIndex()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl);

		$response
			->assertStatus(403)
			->assertJson(['message' => 'This action is unauthorized.']);
	}

	public function testIndexAsAdmin()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl);

		$response
			->assertStatus(200)
			->assertJson([$user->toArray()]);
	}

	public function testShow()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl . '/' . $user->id);

		$response
			->assertStatus(200)
			->assertJson($user->toArray());
	}

	public function testShowWithoutAdmin()
	{
		$user = factory(User::class)->create();
		$anotherUser = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl . '/' . $anotherUser->id);

		$response
			->assertStatus(403)
			->assertJson(['message' => 'This action is unauthorized.']);
	}

	public function testShowWithAdmin()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$anotherUser = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl . '/' . $anotherUser->id);

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
			->json('GET', $this->baseUrl . '/' . $user->id . '/todos');

		$response
			->assertStatus(200)
			->assertJson([$todo->toArray()]);
	}

	public function testShowTodosWithoutAdmin()
	{
		$user = factory(User::class)->create();
		$anotherUser = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl . '/' . $anotherUser->id . '/todos');

		$response
			->assertStatus(403)
			->assertJson(['message' => 'This action is unauthorized.']);
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
			->json('GET', $this->baseUrl . '/' . $anotherUser->id . '/todos');

		$response
			->assertStatus(200)
			->assertJson([$todo->toArray()]);
	}

	public function testStoreWithMissingParams()
	{
		$user = factory(User::class)->create();
		$response = $this->actingAs($user, 'api')
			->json('POST', $this->baseUrl);

		$response
			->assertStatus(400);
	}

	public function testStoreWithValidParams()
	{
		$user = factory(User::class)->create();
		$anotherUser = factory(User::class)->make();

		$response = $this->actingAs($user, 'api')
			->json('POST', $this->baseUrl, ['name' => $anotherUser->name, 'email' => $anotherUser->email, 'password' => 'secret']);

		$response
			->assertStatus(201)
			->assertJson(['name' => $anotherUser->name, 'email' => $anotherUser->email]);
	}

	public function testUpdate()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$anotherUser = factory(User::class)->create();

		$response = $this->actingAs($user, 'api')
			->json('PUT', $this->baseUrl . '/' . $anotherUser->id, ['name' => 'baconbaconbacon']);

		$response
			->assertStatus(200)
			->assertJson(['name' => 'baconbaconbacon', 'email' => $anotherUser->email]);
	}

	public function testDelete()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$anotherUser = factory(User::class)->create();

		$response = $this->actingAs($user, 'api')
			->json('DELETE', $this->baseUrl .'/' . $anotherUser->id);

		$response
			->assertStatus(204);
	}
}

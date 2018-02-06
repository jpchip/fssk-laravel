<?php

namespace Tests\Feature;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
	use RefreshDatabase;

	protected $baseUrl = '/api/todos';

	public function testIndex()
	{
		$user = factory(User::class)->create();
		$todo = factory(Todo::class)->create([
			'user_id' => $user->id
		]);

		$anotherUser = factory(User::class)->create();
		$anotherTodo = factory(Todo::class)->create([
			'user_id' => $anotherUser->id
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl);

		$response
			->assertStatus(200)
			->assertJson([$todo->toArray()]);
	}

	public function testIndexAsAdmin()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$anotherUser = factory(User::class)->create();
		$todo = factory(Todo::class)->create([
			'user_id' => $anotherUser->id
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl);

		$response
			->assertStatus(200)
			->assertJson([$todo->toArray()]);
	}

	public function testShow()
	{
		$user = factory(User::class)->create();
		$todo = factory(Todo::class)->create([
			'user_id' => $user->id
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl . '/' . $todo->id);

		$response
			->assertStatus(200)
			->assertJson($todo->toArray());
	}

	public function testShowWithoutAdmin()
	{
		$user = factory(User::class)->create();
		$anotherUser = factory(User::class)->create();
		$todo = factory(Todo::class)->create([
			'user_id' => $anotherUser->id
		]);

		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl . '/' . $todo->id);

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
		$anotherTodo = factory(Todo::class)->create([
			'user_id' => $anotherUser->id
		]);
		$response = $this->actingAs($user, 'api')
			->json('GET', $this->baseUrl .'/' . $anotherTodo->id);

		$response
			->assertStatus(200)
			->assertJson($anotherTodo->toArray());
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
		$todo = factory(Todo::class)->make([
			'user_id' => $user->id
		]);

		$response = $this->actingAs($user, 'api')
			->json('POST', $this->baseUrl, $todo->toArray());

		$response
			->assertStatus(201)
			->assertJson(['title' => $todo->title]);
	}

	public function testUpdate()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$todo = factory(Todo::class)->create([
			'user_id' => $user->id
		]);

		$response = $this->actingAs($user, 'api')
			->json('PUT', $this->baseUrl .'/' . $todo->id, ['completed' => true]);

		$response
			->assertStatus(200)
			->assertJson(['completed' => true, 'title' => $todo->title]);
	}

	public function testDelete()
	{
		$user = factory(User::class)->create([
			'is_admin' => true,
		]);
		$todo = factory(Todo::class)->create([
			'user_id' => $user->id
		]);

		$response = $this->actingAs($user, 'api')
			->json('DELETE', $this->baseUrl .'/' . $todo->id);

		$response
			->assertStatus(204);
	}
}

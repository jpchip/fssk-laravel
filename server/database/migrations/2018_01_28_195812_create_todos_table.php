<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('todos', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
			$table->primary('id');

			$table->uuid('user_id');
			$table->foreign('user_id')->references('id')->on('users');

			$table->string('title');
			$table->tinyInteger('order');
			$table->boolean('completed');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('todos');
	}
}

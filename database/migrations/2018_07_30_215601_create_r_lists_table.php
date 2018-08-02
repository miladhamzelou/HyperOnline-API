<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRListsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('r_lists', function (Blueprint $table) {
			$table->increments('id');
			$table->string('user_id', 13);

			$table->string('body');
			$table->string('description')->nullable();

			$table->timestamps();
			$table->string('create_date');
			$table->string('update_date')->nullable();

			$table->foreign('user_id')->references('unique_id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('r_lists');
	}
}

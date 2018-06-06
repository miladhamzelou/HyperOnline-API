<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('presenters', function (Blueprint $table) {
			$table->string('unique_id');
			$table->string('presenter_id', 13)->nullable();
			$table->string('user_id', 13)->nullable();

			$table->tinyInteger('used')->default(1);

			$table->foreign('presenter_id')->references('unique_id')->on('users');
			$table->foreign('user_id')->references('unique_id')->on('users');

			$table->string('create_date');
			$table->string('update_date')->nullable();
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
		Schema::dropIfExists('presenters');
	}
}

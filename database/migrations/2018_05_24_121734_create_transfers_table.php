<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::create('transfers', function (Blueprint $table) {
			$table->string('unique_id', 13)->primary()->unique()->index();
			$table->string('origin_id', 13);
			$table->string('destination_id', 13);
			$table->string('origin_user_id', 13);
			$table->string('destination_user_id', 13);

			$table->string('price');
			$table->string('code');
			$table->text('description')->nullable();
			$table->enum('status', ['abort', 'pending', 'successful'])->default('pending');

			$table->foreign('origin_id')->references('unique_id')->on('wallets');
			$table->foreign('destination_id')->references('unique_id')->on('wallets');
			$table->foreign('origin_user_id')->references('unique_id')->on('users');
			$table->foreign('destination_user_id')->references('unique_id')->on('users');

			$table->string('create_date');
			$table->string('update_date')->nullable();
			$table->timestamps();
		});
		Schema::enableForeignKeyConstraints();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('transfers');
	}
}

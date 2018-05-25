<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::create('wallets', function (Blueprint $table) {
			$table->string('unique_id', 13)->primary()->unique()->index();
			$table->string('user_id', 13);

			$table->string('title')->default('اصلی');
			$table->string('price')->default(0);
			$table->string('code');
			$table->string('min')->default('0');
			$table->string('max')->default('0');
			$table->enum('status', ['active', 'inactive'])->default('inactive');
			$table->text('description')->nullable();

			$table->foreign('user_id')->references('unique_id')->on('users');

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
		Schema::dropIfExists('wallets');
	}
}

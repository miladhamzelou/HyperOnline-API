<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::create('transactions', function (Blueprint $table) {
			$table->string('unique_id', 13)->primary()->unique()->index();
			$table->string('company_id', 13)->nullable();
			$table->string('user_id');
			$table->string('wallet_id');

			$table->string('price');
			$table->string('code');
			$table->string('card')->nullable();
			$table->text('description')->nullable();
			$table->enum('status', ['abort', 'pending', 'successful'])->default('pending');

			$table->foreign('company_id')->references('unique_id')->on('companies');
			$table->foreign('user_id')->references('unique_id')->on('users');
			$table->foreign('wallet_id')->references('unique_id')->on('wallets');

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
		Schema::dropIfExists('transactions');
	}
}

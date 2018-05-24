<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::create('discounts', function (Blueprint $table) {
			$table->string('unique_id', 13)->primary()->unique()->index();

			$table->string('code');
			$table->string('percent');
			$table->string('min_price');
			$table->dateTime('expire')->nullable();
			$table->enum('status', ['active', 'inactive'])->default('inactive');
			$table->text('rules')->nullable();
			$table->integer('max_use')->default(0);
			$table->integer('usage')->default(0);

			$table->string('create_date');
			$table->string('update_date');
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
		Schema::dropIfExists('discounts');
	}
}

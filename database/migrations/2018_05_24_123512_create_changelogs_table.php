<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangelogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::create('changelogs', function (Blueprint $table) {
			$table->string('unique_id', 13)->primary()->unique()->index();

			$table->integer('version');
			$table->longText('changes');

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
		Schema::dropIfExists('changlogs');
	}
}

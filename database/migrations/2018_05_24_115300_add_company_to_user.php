<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyToUser extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::table('users', function (Blueprint $table) {
			$table->string('company_id', 13)->nullable();
			$table->foreign('company_id')->references('unique_id')->on('companies');
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
		Schema::disableForeignKeyConstraints();
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('company_id');
		});
		Schema::enableForeignKeyConstraints();
	}
}

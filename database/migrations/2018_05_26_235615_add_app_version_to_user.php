<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppVersionToUser extends Migration
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
		    $table->integer('android')->nullable();
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
		    $table->dropColumn('android');
	    });
	    Schema::enableForeignKeyConstraints();
    }
}

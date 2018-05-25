<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveWalletFromUser extends Migration
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
		    $table->dropColumn('wallet');
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
		    $table->integer('wallet')->default(0);
	    });
	    Schema::enableForeignKeyConstraints();
    }
}

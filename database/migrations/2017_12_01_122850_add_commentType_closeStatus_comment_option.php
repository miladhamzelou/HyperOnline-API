<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentTypeCloseStatusCommentOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0);
        });

        Schema::table('options', function (Blueprint $table) {
            $table->tinyInteger('offline')->default(0);
            $table->string('offline_msg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('offline');
            $table->dropColumn('offline_msg');
        });
    }
}
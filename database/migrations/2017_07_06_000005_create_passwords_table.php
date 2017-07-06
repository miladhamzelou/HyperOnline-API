<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwords', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('user_id', 13);
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('unique_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passwords');
    }
}

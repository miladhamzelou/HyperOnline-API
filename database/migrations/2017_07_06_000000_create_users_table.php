<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->unique();
            $table->text('address');
            $table->string('encrypted_password');
            $table->string('salt');
            $table->integer('wallet')->default(0);
            $table->string('state');
            $table->string('city');
            $table->string('district')->nullable();
            $table->integer('confirmed_email')->default(0);
            $table->integer('confirmed_phone')->default(0);
            $table->string('location_x')->nullable();
            $table->string('location_y')->nullable();
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

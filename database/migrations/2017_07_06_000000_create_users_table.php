<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('code', 13)->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('phone')->unique();
            $table->text('address');
            $table->string('encrypted_password');
            $table->string('salt');
            $table->string('password');
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
            $table->boolean('active')->default(true);
            $table->enum('role', ['developer', 'admin', 'user', 'guest'])->default('user');
            $table->rememberToken();
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

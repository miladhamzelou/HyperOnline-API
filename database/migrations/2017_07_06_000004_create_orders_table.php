<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('seller_id', 13);
            $table->string('user_id', 13);
            $table->string('seller_name');
            $table->string('user_name');
            $table->string('user_phone');
            $table->text('stuffs');
            $table->text('stuffs_id');
            $table->integer('price');
            $table->text('description')->nullable();
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('unique_id')->on('sellers');
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
        Schema::dropIfExists('orders');
    }
}

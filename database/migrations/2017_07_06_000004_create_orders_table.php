<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('code');
            $table->string('seller_name');
            $table->string('user_name');
            $table->string('user_phone');
            $table->text('stuffs');
            $table->text('stuffs_id');
            $table->text('stuffs_count');
            $table->integer('price');
            $table->integer('price_send');
            $table->integer('price_original');
            $table->integer('hour');
            $table->enum('pay_method', ['online', 'place']);
            $table->enum('status', ['abort', 'pending', 'shipped', 'delivered'])->default('pending');
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

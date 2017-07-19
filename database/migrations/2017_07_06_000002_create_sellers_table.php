<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('author_id', 13);
            $table->string('name');
            $table->string('image')->nullable();
            $table->float('point', 2, 1)->default(0.0);
            $table->integer('point_count')->default(0);
            $table->text('address');
            $table->integer('open_hour');
            $table->integer('close_hour');
            $table->integer('off')->default(0);
            $table->integer('type');
            $table->integer('closed')->default(0);
            $table->integer('confirmed')->default(0);
            $table->string('phone');
            $table->string('state');
            $table->string('city');
            $table->text('description')->nullable();
            $table->integer('send_price')->default(0);
            $table->integer('min_price')->default(0);
            $table->string('location_x')->nullable();
            $table->string('location_y')->nullable();
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
            $table->foreign('author_id')->references('unique_id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}

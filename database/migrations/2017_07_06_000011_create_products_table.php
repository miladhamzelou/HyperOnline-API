<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('seller_id', 13);
            $table->string('category_id', 13);
            $table->string('name');
            $table->string('image')->nullable();
            $table->float('point', 2, 1)->default(0.0);
            $table->integer('point_count')->default(0);
            $table->text('description')->nullable();
            $table->integer('off')->default(0);
            $table->integer('count')->default(0);
            $table->integer('confirmed')->default(0);
            $table->integer('price');
            $table->integer('price_original');
            $table->integer('type');
            $table->text('other')->nullable();
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('unique_id')->on('sellers');
            $table->foreign('category_id')->references('unique_id')->on('category3s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

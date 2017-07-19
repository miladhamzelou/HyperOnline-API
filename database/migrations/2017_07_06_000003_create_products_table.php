<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('type')->nullable()->default(0);
            $table->integer('count')->default(0);
            $table->integer('confirmed')->default(0);
            $table->integer('price');
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('unique_id')->on('sellers');
            $table->foreign('seller_id')->references('unique_id')->on('sellers');
            $table->foreign('category_id')->references('unique_id')->on('categories');
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

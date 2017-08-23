<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->integer('category')->default(1);
            $table->integer('category_count')->default(6);
            $table->integer('off')->default(1);
            $table->integer('off_count')->default(12);
            $table->integer('new')->default(1);
            $table->integer('new_count')->default(12);
            $table->integer('popular')->default(1);
            $table->integer('popular_count')->default(12);
            $table->integer('most_sell')->default(1);
            $table->integer('most_sell_count')->default(12);
            $table->integer('collection')->default(1);
            $table->integer('collection_count')->default(12);
            $table->integer('banner')->default(0);
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
        Schema::dropIfExists('options');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategory1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category1s', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('name');
            $table->string('image')->nullable();
            $table->float('point', 2, 1)->default(0.0);
            $table->integer('point_count')->default(0);
            $table->integer('off')->default(0);
            $table->integer('type')->default(0);
            $table->integer('type_name')->nullable();
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
        Schema::dropIfExists('category1s');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('name');
            $table->string('phone');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('country')->default("Iran");
            $table->string('state');
            $table->string('city');
            $table->string('image')->nullable();
            $table->string('address');
            $table->string('mCode', 10)->unique();
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
        Schema::dropIfExists('authors');
    }
}

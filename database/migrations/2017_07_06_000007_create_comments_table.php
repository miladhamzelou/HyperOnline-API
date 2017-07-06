<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('target_id', 13);
            $table->string('user_id', 13);
            $table->integer('target_type');
            $table->string('sender_name');
            $table->text('body');
            $table->text('answer')->nullable();
            $table->integer('confirmed')->default(0);
            $table->string('create_date');
            $table->string('update_date')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('passwords');
    }
}

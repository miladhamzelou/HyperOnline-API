<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->string('unique_id', 13)->primary()->unique()->index();
            $table->string('name')->nullable();
            $table->string('os_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('version_release')->nullable();
            $table->string('device')->nullable();
            $table->string('model')->nullable();
            $table->string('product')->nullable();
            $table->string('brand')->nullable();
            $table->string('display')->nullable();
            $table->string('abi')->nullable();
            $table->string('abi2')->nullable();
            $table->string('unknown')->nullable();
            $table->string('hardware')->nullable();
            $table->string('id2')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('serial')->nullable();
            $table->string('user')->nullable();
            $table->string('host')->nullable();
            $table->string('location_x')->nullable();
            $table->string('location_y')->nullable();
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
        Schema::dropIfExists('devices');
    }
}

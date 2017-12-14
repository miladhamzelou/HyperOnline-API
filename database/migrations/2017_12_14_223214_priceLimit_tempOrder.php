<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PriceLimitTempOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // price limit for shop_card
            $table->integer('minPrice')->default(0);
            $table->integer('maxPrice')->default(0);
        });

        Schema::table('orders', function (Blueprint $table) {
            // for temp saving order before pay price
            $table->tinyInteger('temp')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('minPrice');
            $table->dropColumn('maxPrice');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('temp');
        });
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecondSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require(app_path() . '/Common/jdf.php');

        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        factory(App\Order::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

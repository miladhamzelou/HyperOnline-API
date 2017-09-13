<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require(app_path() . '/Common/jdf.php'); // use / for and \ for windows

        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        factory(App\User::class, 1)->create();
        factory(App\Author::class, 1)->create();
        factory(App\Seller::class, 1)->create();
        factory(App\Option::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

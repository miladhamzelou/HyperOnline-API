<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // cal jdf file once here for all factory files
        require(app_path() . '/Common/jdf.php'); // use / for and \ for windows

        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        factory(App\Author::class, 5)->create();

        /*factory(App\Seller::class, 10)->create()->each(function ($seller) {
            factory(App\Product::class, 20)->make()->each(function ($product) use ($seller) {
                $seller->products()->save($product);
            });
        });*/

        factory(App\Seller::class, 10)->create();
        factory(App\Product::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

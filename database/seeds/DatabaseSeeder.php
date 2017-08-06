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

        /*factory(App\Category1::class, 5)
            ->create()
            ->each(function ($category1) {
                $ids = \App\Category1::all()->pluck('unique_id')->toArray();
                factory(App\Category2::class, 10)
                    ->create()
                    ->each(function ($category2) use ($ids) {

                    });
            });*/
        factory(App\User::class, 1)->create();
        factory(App\Author::class, 5)->create();
        factory(App\Category1::class, 8)->create();
        factory(App\Category2::class, 25)->create();
        factory(App\Category3::class, 50)->create();
        factory(App\Seller::class, 10)->create();
        factory(App\Product::class, 1000)->create();
        factory(App\Order::class, 100)->create();
        factory(App\Option::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$autoIncrement = autoIncrement();

$factory->define(App\Order::class, function (Faker\Generator $faker) use ($autoIncrement) {
    $autoIncrement->next();

    $sellers = \App\Seller::all()->pluck('unique_id')->toArray();
    $users = \App\User::all()->pluck('unique_id')->toArray();

    $timezone = 0;
    $now = date("Y-m-d", time() + $timezone);
    $time = date("H:i:s", time() + $timezone);
    list($year, $month, $day) = explode('-', $now);
    list($hour, $minute, $second) = explode(':', $time);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date = jdate("Y-m-d:H-i-s", $timestamp);

    $seller = $faker->randomElement($sellers);
    $user = $faker->randomElement($users);
    $seller_name = \App\Seller::where("unique_id", $seller)->firstOrFail()->name;
    $user_name = \App\User::where("unique_id", $user)->firstOrFail()->name;
    $user_phone = \App\User::where("unique_id", $user)->firstOrFail()->phone;

    $count = $faker->numberBetween(1, 8);
    $product = \App\Product::inRandomOrder()->take($count)->get();

    $price = 0;
    $stuffs = "";
    $stuffs_id = "";
    foreach ($product as $item) {
        $stuffs .= '-' . $item->name;
        $stuffs_id .= '-' . $item->unique_id;
        $price += $item->price;
    }
    // remove first '-' in string
    $stuffs = ltrim($stuffs, '-');
    $stuffs_id = ltrim($stuffs_id, '-');

    $status = ['abort', 'pending', 'shipped', 'delivered'];
    return [
        'unique_id' => str_random(13),
        'seller_id' => $seller,
        'user_id' => $user,
        'code' => "HOS-" . strval($autoIncrement->current()),
        'seller_name' => $seller_name,
        'user_name' => $user_name,
        'user_phone' => $user_phone,
        'stuffs' => $stuffs,
        'stuffs_id' => $stuffs_id,
        'price' => $price,
	'hour' => $faker->numberBetween(10, 22),
        'status' => $faker->randomElement($status),
        'create_date' => $date,
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now')
    ];
});

function autoIncrement()
{
    for ($i = 1; $i < 101; $i++)
        yield $i;
}

<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    $seller = \App\Seller::all()->pluck('unique_id')->toArray();
    $timezone = 0;
    $now = date("Y-m-d", time() + $timezone);
    $time = date("H:i:s", time() + $timezone);
    list($year, $month, $day) = explode('-', $now);
    list($hour, $minute, $second) = explode(':', $time);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date = jdate("Y-m-d:H-i-s", $timestamp);

    return [
        'unique_id' => str_random(13),
        'seller_id' => $faker->randomElement($seller),
        'name' => $faker->name,
        'point' => $faker->randomFloat(1, 0.0, 9.9),
        'point_count' => $faker->numberBetween(0, 100),
        'price' => $faker->numberBetween(1000, 25000),
        'create_date' => $date
    ];
});
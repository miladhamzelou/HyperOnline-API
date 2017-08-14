<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$factory->define(App\Category3::class, function (Faker\Generator $faker) {
    $categories = \App\Category2::all()->pluck('unique_id')->toArray();
    $timezone = 0;
    $now = date("Y-m-d", time() + $timezone);
    $time = date("H:i:s", time() + $timezone);
    list($year, $month, $day) = explode('-', $now);
    list($hour, $minute, $second) = explode(':', $time);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date = jdate("Y-m-d:H-i-s", $timestamp);
    $parent_id = $faker->randomElement($categories);
    $parent_name = \App\Category2::where("unique_id", $parent_id)->firstOrFail()->name;

    return [
        'unique_id' => str_random(13),
        'parent_id' => $parent_id,
        'parent_name' => $parent_name,
        'name' => $faker->name,
        'point' => $faker->randomFloat(1, 0.0, 9.9),
        'point_count' => $faker->numberBetween(0, 100),
        'create_date' => $date,
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-29 days')
    ];
});
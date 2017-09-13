<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$factory->define(App\Seller::class, function (Faker\Generator $faker) {
    $authors = \App\Author::all()->pluck('unique_id')->toArray();
    $timezone = 0;
    $now = date("Y-m-d", time() + $timezone);
    $time = date("H:i:s", time() + $timezone);
    list($year, $month, $day) = explode('-', $now);
    list($hour, $minute, $second) = explode(':', $time);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date = jdate("Y-m-d:H-i-s", $timestamp);

    return [
        'unique_id' => "vbkYwlL98I3F3",
        'author_id' => $faker->randomElement($authors),
        'name' => "HyperOnline",
        'address' => "Mahdieh St",
        'open_hour' => "9",
        'close_hour' => "21",
        'type' => "0",
        'phone' => "08138263324",
        'state' => "Hamedan",
        'city' => "Hamedan",
        'confirmed' => '1',
        'create_date' => $date,
        'location_x' => $faker->latitude,
        'location_y' => $faker->longitude,
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-29 days')
    ];
});
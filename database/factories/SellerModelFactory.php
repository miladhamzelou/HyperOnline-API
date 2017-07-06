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
        'unique_id' => str_random(13),
        'author_id' => $faker->randomElement($authors),
        'name' => $faker->name,
        'point' => $faker->randomFloat(1, 0.0, 9.9),
        'point_count' => $faker->numberBetween(0, 100),
        'address' => $faker->address,
        'open_hour' => $faker->numberBetween(1, 24),
        'close_hour' => $faker->numberBetween(1, 24),
        'off' => $faker->numberBetween(0, 100),
        'type' => $faker->numberBetween(0, 2),
        'phone' => $faker->e164PhoneNumber,
        'state' => $faker->state,
        'city' => $faker->city,
        'video' => $faker->numberBetween(0, 1),
        'create_date' => $date,
        'location_x' => $faker->latitude,
        'location_y' => $faker->longitude
    ];
});
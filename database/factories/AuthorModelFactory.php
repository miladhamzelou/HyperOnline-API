<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$factory->define(App\Author::class, function (Faker\Generator $faker) {
    $timezone = 0;
    $now = date("Y-m-d", time() + $timezone);
    $time = date("H:i:s", time() + $timezone);
    list($year, $month, $day) = explode('-', $now);
    list($hour, $minute, $second) = explode(':', $time);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date = jdate("Y-m-d:H-i-s", $timestamp);

    return [
        'unique_id' => str_random(13),
        'name' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'mobile' => $faker->e164PhoneNumber,
        'email' => $faker->email,
        'state' => $faker->state,
        'city' => $faker->city,
        'address' => $faker->address,
        'mCode' => $faker->numberBetween(1000000000, 2147483646),
        'create_date' => $date,
        'created_at' => \Carbon\Carbon::now()
    ];
});
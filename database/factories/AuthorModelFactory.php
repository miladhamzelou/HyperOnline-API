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
        'name' => "Amir H.Babaei",
        'phone' => "08138263324",
        'mobile' => "09188167800",
        'state' => "Hamedan",
        'city' => "Hamedan",
        'address' => "Mahdieh St",
        'mCode' => "3860467174",
        'create_date' => $date,
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-29 days')
    ];
});
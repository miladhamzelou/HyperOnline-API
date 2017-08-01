<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $timezone = 0;
    $now = date("Y-m-d", time() + $timezone);
    $time = date("H:i:s", time() + $timezone);
    list($year, $month, $day) = explode('-', $now);
    list($hour, $minute, $second) = explode(':', $time);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $date = jdate("Y-m-d:H-i-s", $timestamp);

    return [
        'unique_id' => str_random(13),
        'name' => 'آرش حاتمی',
        'email' => 'hatamiarash7@gmail.com',
        'phone' => '09182180519',
        'address' => 'خیابان صدوقی',
        'encrypted_password' => 'VfwHcIswcPa6J0ZVJ9D5iKTvzXZmMjlmY2Y5OTMx',
        'salt' => 'f29fcf9931',
        'state' => 'همدان',
        'city' => 'ملایر',
        'create_date' => $date
    ];
});
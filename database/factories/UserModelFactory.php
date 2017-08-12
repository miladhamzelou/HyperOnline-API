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
        'code' => 'HO-1',
        'phone' => '09182180519',
        'address' => 'خیابان صدوقی',
        'encrypted_password' => '761CC5lvW+K7DJNi2pN13gx1/rw3MzkyYWNjMGVh',
        'salt' => '7392acc0ea',
        'password' => '$2y$10$aQ8N5yFeQ1BC.xN/1dQnrehQg43hg75pxNWglZ9CuOwDmEseRcSQa',
        'state' => 'همدان',
        'city' => 'ملایر',
        'role' => 'admin',
        'create_date' => $date,
        'active' => '1',
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now')
    ];
});
<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

$factory->define(App\Option::class, function (Faker\Generator $faker) {

    return [
        'unique_id' => str_random(13)
    ];
});
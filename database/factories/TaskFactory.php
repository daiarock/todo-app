<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name' => 'Sample Task',
        'is_done' => 0,
    ];
});

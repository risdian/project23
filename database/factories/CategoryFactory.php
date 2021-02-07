<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'          =>  $faker->name,
        'title'         =>  $faker->realText(100),
        'subtitle'         =>  $faker->realText(30),
        'parent_id'     =>  1,
        'menu'          =>  1,
    ];
});

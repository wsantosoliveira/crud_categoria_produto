<?php

use Faker\Generator as Faker;

$factory->define(CodeShopping\Models\Product::class, function (Faker $faker) {
    return [
        "name" => $faker->city,
        "description" => $faker->firstNameMale,
        "price" => $faker->randomFloat(2, 0, 9999)
    ];
});

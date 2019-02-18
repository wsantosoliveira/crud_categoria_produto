<?php

use CodeShopping\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name" => $faker->city,
        "description" => $faker->firstNameMale,
        "price" => $faker->randomFloat(2, 0, 9999)
    ];
});

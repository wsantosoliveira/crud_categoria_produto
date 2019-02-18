<?php

use CodeShopping\Models\Category;
use CodeShopping\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        factory(Product::class, 30)
            ->create()
            ->each(function (Product $product) use ($categories) {
                $product->categories()->attach($categories->random()->id);
            });
    }
}

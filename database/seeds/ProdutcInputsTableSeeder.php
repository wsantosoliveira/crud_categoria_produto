<?php

use CodeShopping\Models\Product;
use CodeShopping\Models\ProductInput;
use Illuminate\Database\Seeder;

class ProdutcInputsTableSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        factory(ProductInput::class, 150)
            ->make()
            ->each(function (ProductInput $productInput) use ($products) {
                $productInput->product_id = $products->random()->id;
                $productInput->save();
            });
    }
}

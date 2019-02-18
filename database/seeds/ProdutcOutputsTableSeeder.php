<?php

use CodeShopping\Models\Product;
use CodeShopping\Models\ProductOutput;
use Illuminate\Database\Seeder;

class ProdutcOutputsTableSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        factory(ProductOutput::class, 150)
            ->make()
            ->each(function (ProductOutput $productOutput) use ($products) {
                $productOutput->product_id = $products->random()->id;
                $productOutput->save();
            });
    }
}

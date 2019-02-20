<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProdutcInputsTableSeeder::class);
        $this->call(ProdutcOutputsTableSeeder::class);
        $this->call(ProdutcPhotosTableSeeder::class);
    }
}

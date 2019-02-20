<?php

use CodeShopping\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 1)->create(["name" => "Admin", "email" => "admin_admin@gmail.com"]);
        factory(User::class, 10)->create();
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInputsTable extends Migration
{
    public function up()
    {
        Schema::create("product_inputs", function (Blueprint $table) {
            $table->increments("id");
            $table->integer("amount")->unsigned();
            $table->integer("product_id")->unsigned();
            $table->foreign("product_id")->references("id")->on("products");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("product_inputs");
    }
}

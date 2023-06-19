<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->string('product_color');
            $table->string('product_size');
            $table->string('product_price');
            $table->string('product_capital');
            $table->string('good_stock')->default(0);
            $table->string('bad_stock')->default(0);
            $table->unsignedBigInteger('supplier_id');
            $table->foreign("supplier_id")->references("id")->on("suppliers");
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->foreign("brand_id")->references("id")->on("brands");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

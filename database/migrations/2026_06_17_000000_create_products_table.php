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
            $table->string('item_code', 100)->nullable($value = true);
            $table->string('product_name', 100);
            $table->string('product_description', 250)->nullable($value = true);
            $table->integer('product_type_id');
            $table->integer('category_id')->nullable($value = true);
            $table->double('low_stock_qty')->nullable($value = true)->default(0);
            $table->integer('unit_id')->nullable($value = true);
            $table->tinyInteger('on_sale')->nullable($value = true)->default(0);
            $table->tinyInteger('active');
            $table->integer('company_id')->nullable($value = true);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('modified_at')->nullable()->useCurrent()->useCurrentOnUpdate();
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

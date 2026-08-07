<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductTypeIdToStringOnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('product_type_id', 'product_type');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('product_type', 4)
                ->comment('S = Single product, V = Product variant, P = Product Pack')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_type')->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('product_type', 'product_type_id');
        });
    }
}

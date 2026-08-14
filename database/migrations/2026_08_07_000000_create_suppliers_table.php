<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('suppliers');

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code', 50);
            $table->string('supplier_name', 200);
            $table->decimal('credit_limit')->nullable($value = true)->default(null);
            $table->integer('credit_period')->nullable($value = true)->default(null);
            $table->integer('tax_category_id')->nullable($value = true)->default(null);
            $table->integer('active')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable($value = true)->default(null);
            $table->integer('deleted_by')->nullable($value = true)->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}

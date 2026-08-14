<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address_type', 20);
            $table->string('address_line_1', 100);
            $table->string('address_line_2', 100)->nullable($value = true)->default(null);
            $table->string('address_line_3', 100)->nullable($value = true)->default(null);
            $table->string('city', 100)->nullable($value = true)->default(null);
            $table->string('district', 100)->nullable($value = true)->default(null);
            $table->string('province', 50)->nullable($value = true)->default(null);
            $table->string('postal_code', 15)->nullable($value = true)->default(null);
            $table->integer('is_primary')->nullable($value = true)->default(null);
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
        Schema::dropIfExists('addresses');
    }
}

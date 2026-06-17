<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_code', 6);
            $table->string('location_name', 100);
            $table->string('address1', 50)->nullable()->default(null);
            $table->string('address2', 50)->nullable()->default(null);
            $table->string('address3', 50)->nullable()->default(null);
            $table->string('telephone1')->nullable()->default(null);
            $table->string('telephone2')->nullable()->default(null);
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('locations');
    }
}

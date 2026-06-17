<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('address_line_1', 50)->nullable(false);
            $table->string('address_line_2', 50)->nullable(true);
            $table->string('address_line_3', 50)->nullable(true);
            $table->string('address_line_4', 50)->nullable(true);
            $table->string('mobile_no', 20)->nullable(false);
            $table->string('telephone', 20)->nullable(true);
            $table->string('email', 50)->nullable(true);
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
        Schema::dropIfExists('contact_details');
    }
}


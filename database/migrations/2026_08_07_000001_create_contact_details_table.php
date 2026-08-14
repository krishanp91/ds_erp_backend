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
        Schema::dropIfExists('contact_details');

        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name', 200);
            $table->string('designation', 200)->nullable($value = true)->default(null);
            $table->string('email', 100)->nullable($value = true)->default(null);
            $table->string('phone', 20)->nullable($value = true)->default('');
            $table->string('mobile', 20)->nullable($value = true)->default('');
            $table->integer('is_primary');
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
        Schema::dropIfExists('contact_details');
    }
}

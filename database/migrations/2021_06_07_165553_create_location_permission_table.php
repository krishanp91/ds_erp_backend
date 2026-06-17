<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_permission', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id');
            $table->integer('permission_id');
            $table->integer('active')->default(1);
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamps();
        });
    }
}

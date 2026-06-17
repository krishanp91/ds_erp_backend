<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
          $table->id();
          $table->string('company_name', 100);
          $table->string('company_address1', 100)->nullable()->default(null);
          $table->string('company_address2', 100)->nullable()->default(null);
          $table->string('company_address3', 100)->nullable()->default(null);
          $table->string('company_tel1', 15)->nullable()->default(null);
          $table->string('company_tel2', 15)->nullable()->default(null);
          $table->string('company_fax', 15)->nullable()->default(null);
          $table->string('company_email', 100)->nullable()->default(null);
          $table->string('company_web', 50)->nullable()->default(null);
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
        Schema::dropIfExists('companies');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeVerificationAssetModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_verification_asset_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_id');
            $table->string('asset_type')->nullable();
            $table->string('a_brand')->nullable();
            $table->string('a_model')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('assetid')->nullable();
            $table->string('category')->nullable();
            $table->string('dongle')->nullable();
            $table->string('remark')->nullable();
            $table->string('spec_ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('created_by')->nullable();
            $table->string('returned_status')->nullable();
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
        Schema::dropIfExists('employee_verification_asset_models');
    }
}

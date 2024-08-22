<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeVerificationModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_verification_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_id')->unique();
            $table->string('emp_status')->nullable();
            $table->string('fullname');
            $table->string('band');
            $table->string('grade');
            $table->string('division');
            $table->string('role');
            $table->string('work_from_home');
            $table->string('email');
            $table->string('city')->nullable();
            $table->string('office_city')->nullable();
            $table->text('mobile');
            $table->text('office');
            $table->string('verified_by');
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
        Schema::dropIfExists('employee_verification_models');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Employee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_id',255)->unique();
            $table->string('business',255);
            $table->integer('departmentid');
            $table->string('fullname',255);
            $table->string('email',255);
            $table->string('jobrole',255);
            $table->string('city',255)->nullable();
            $table->string('country',255)->nullable();
            $table->text('address')->nullable();
            $table->string('cost_center',255);
            $table->string('specialrole',255);
            $table->string('supervisor',255)->nullable();
            $table->string('status',255)->nullable();
            
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
        Schema::dropIfExists( 'employees' );
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Asset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assetid',50)->unique();
            $table->string('type');
            $table->string('a_c_id');
            $table->string('a_type_id');
            $table->string('locationid');
            $table->integer('brandid');
            $table->string('barcode',50);
            $table->string('name',255);
            $table->string('quantity',10);
            $table->date('date');
            $table->string('cost',10);
            $table->string('warranty',5);
            $table->string('available_status',20);
            $table->string('emp_id')->nullable();
            $table->string('spoc_emp_id')->nullable();
            $table->string('status',20);
            $table->text('picture')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists( 'assets' );
    }
}

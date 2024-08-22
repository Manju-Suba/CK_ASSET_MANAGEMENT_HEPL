<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSofHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sof_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assetid',50);
            $table->string('sof_cost',10);
            $table->text('picture')->nullable();
            $table->date('expirydate');
            $table->date('extenddate');
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
        Schema::dropIfExists('sof_history');
    }
}

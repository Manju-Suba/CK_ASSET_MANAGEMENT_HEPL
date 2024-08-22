<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssetHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assetid',200);
            $table->string('employeeid',200)->nullable();
            $table->date('allocated_date')->nullable();
            $table->date('get_back_date')->nullable();
            $table->date('retiraldate')->nullable();
            $table->string('type',200)->nullable();
            $table->string('location',200)->nullable();
            $table->string('reason',200)->nullable();
            $table->text('remark')->nullable();
            $table->string('status',50);
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
        Schema::dropIfExists( 'asset_history' );
    }
}

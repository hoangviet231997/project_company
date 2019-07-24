<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommissionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_detail', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('commission_master_id');
            $table->integer('product_id')->nullable();
            $table->integer('product_amount')->nullable();
            $table->double('commission_percent',11,3)->nullable();
            $table->tinyInteger('invalid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commission_detail');
    }
}

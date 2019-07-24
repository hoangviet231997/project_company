<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_level', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('shop_id');
            $table->integer('shop_parent_id');
            $table->tinyInteger('level')->default(null);
            $table->tinyInteger('invalid')->default(0)->comment('0:active, 1:deActive');
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
        Schema::dropIfExists('shop_level');
    }
}

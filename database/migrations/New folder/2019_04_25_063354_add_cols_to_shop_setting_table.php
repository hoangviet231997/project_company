<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToShopSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_setting', function (Blueprint $table) {
			$table->integer('order_stage_id_subtract_inventory')
				  ->default(0);
			$table->tinyInteger('select_shift_when_order')
				  ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_setting', function (Blueprint $table) {
            //
        });
    }
}

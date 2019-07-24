<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColsToShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('shop', function (Blueprint $table) {
			$table->dropColumn('type');
		});

        Schema::table('shop', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1)->comment('1: pharmacy; 2: spa; 3: retail')->after('tax');
            $table->tinyInteger('public_shop_flg')->default(0)->after('country_code');
            $table->string('open_hour', 255)->nullable()->comment('giờ mở cửa')->after('business_start_hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop', function (Blueprint $table) {
            //
        });
    }
}

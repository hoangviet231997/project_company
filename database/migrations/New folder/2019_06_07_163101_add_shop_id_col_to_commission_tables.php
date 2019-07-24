<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopIdColToCommissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_master', function (Blueprint $table) {
            $table->integer('shop_id')->default(0)->after('id');
        });

        Schema::table('account_commission', function (Blueprint $table) {
            $table->integer('shop_id')->default(0)->after('id');
        });

        Schema::table('dealer_commission', function (Blueprint $table) {
            $table->integer('shop_id')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_master', function (Blueprint $table) {
            //
        });
        Schema::table('account_commission', function (Blueprint $table) {
        });

        Schema::table('dealer_commission', function (Blueprint $table) {
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountCommissionAndDealerCommissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('account_commission', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('account_id')->nullable();
			$table->integer('commission_id')->nullable();

		});

		Schema::create('dealer_commission', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('dealer_id')->nullable();
			$table->integer('commission_id')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_commission_and_dealer_commission_tables');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssetAmountLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asset_amount_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('asset_id')->nullable();
			$table->integer('shop_id');
			$table->decimal('pre_asset_total', 24)->nullable();
			$table->decimal('asset_total', 24)->nullable();
			$table->decimal('after_asset_total', 24)->nullable();
			$table->date('datelog_business_date')->nullable()->comment('business date theo ngày');
			$table->integer('datelog_business_date_timestamp')->nullable()->comment('business date theo ngày (timestamp)');
			$table->dateTime('lastupdate')->nullable();
		});

		DB::statement('ALTER TABLE `asset_amount_log` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `shop_id`) USING BTREE;');
		DB::statement('ALTER TABLE `asset_amount_log` ADD INDEX `datelog_business_date_timestamp` (`datelog_business_date_timestamp`) using BTREE;');
		DB::statement('ALTER TABLE `asset_amount_log` ADD INDEX `sort asset amount log` (`datelog_business_date_timestamp`, `id`) using BTREE;');
		DB::statement('ALTER TABLE `asset_amount_log` ADD INDEX `asset_id, shop_id, datelog_business_date_timestamp` (`asset_id`, `shop_id`, `datelog_business_date`) using BTREE;');

		DB::statement('ALTER TABLE `asset_amount_log` PARTITION BY HASH(`shop_id`) PARTITIONS 50;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('asset_amount_log');
	}

}

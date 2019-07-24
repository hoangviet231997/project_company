<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTablesForCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('shop_setting', function (Blueprint $table) {
			$table->boolean('create_customer_send_sms_flg')->default(0);
		});

		Schema::table('customer_supplier', function (Blueprint $table) {
			$table->dropColumn('account_id');
			$table->string('password')->nullable();
			$table->string('otp_code', 10)->nullable();
			$table->boolean('otp_verify_flg')->default(0);
			$table->string('token', 32)->nullable();
		});

		Schema::create('customer_push', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id');
			$table->integer('shop_id')->default(0);
			$table->string('push_id')->nullable();
			$table->string('device_id')->nullable();
			$table->boolean('device_type')->nullable()->default(0)->comment('0: android; 1: ios');
			$table->boolean('app_type')->nullable()->default(0)->comment('0: ios user');
			$table->boolean('is_push')->nullable()->default(1);
			$table->string('build_version')->nullable();
			$table->string('device_name')->nullable();
			$table->string('os_version')->nullable();
			$table->string('langcode', 10)->nullable()->default('vi');
			$table->dateTime('regdate')->nullable();
			$table->unique(['device_id','app_type'], 'device_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

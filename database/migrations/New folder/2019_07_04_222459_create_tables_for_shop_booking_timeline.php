<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForShopBookingTimeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('shop_default_service_timeline', function (Blueprint $table) {
			$table->integerIncrements('id');
			$table->integer('shop_id')->nullable();
			$table->time('from_time')->nullable();
			$table->time('to_time')->nullable();
			$table->timestamps();
		});

		Schema::create('service_timeline', function (Blueprint $table) {
			$table->integerIncrements('id');
			$table->integer('shop_id')->nullable();
			$table->integer('default_service_timeline_id')->nullable();
			$table->integer('product_id')->nullable()->comment('product has type service');
			$table->smallInteger('staff_count')->default(0);
			$table->smallInteger('staff_serviced_count')->default(0);
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
        Schema::dropIfExists('shop_default_service_timeline');
        Schema::dropIfExists('service_timeline');
    }
}

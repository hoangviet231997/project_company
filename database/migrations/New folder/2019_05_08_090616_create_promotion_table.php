<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromotionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promotion', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('shop_id')->nullable()->index('shopid');
			$table->boolean('promotion_type')->nullable()->default(0)->comment('0: tang mon 1: giam gia hoa don 2: giam gia mon  3: tang gia hoa don; 4: tang gia mon; 5: giam gia hoa don theo KH; 6: goi dich vu');
			$table->boolean('promotion_subtype')->nullable()->default(0)->comment('0: theo %; 1: theo số tiền');
			$table->boolean('promotion_subtype2')->nullable()->default(0)->comment('0: ---; 1: Mua món tặng món');
			$table->float('promotion_value', 10)->nullable()->default(0.00);
			$table->string('promotion_code', 100)->nullable()->index('promotion_code');
			$table->string('promotion_name', 300)->nullable();
			$table->text('promotion_desc', 65535)->nullable();
			$table->string('promotion_image')->nullable();
			$table->boolean('target_type')->nullable()->default(0)->comment('0: ap dung toan bo  1~: ap dung nhóm  khách hàng  (target_detailtype = shop_customer.priceplan)  2 : áp dụng cho hạng thẻ (target_detailtype =  shop_membercard.cardtype)');
			$table->string('target_detailtype')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->boolean('is_weekdays')->nullable()->default(0);
			$table->string('weekdays')->nullable()->comment('0: chu nhat , 1: thu 2 ...');
			$table->boolean('is_time')->nullable()->default(0);
			$table->string('start_time')->nullable();
			$table->string('to_time')->nullable();
			$table->boolean('condition_flag')->nullable()->default(0)->comment('0: ko có; 1: hóa đơn; 2: theo món');
			$table->text('condition_detail', 65535)->nullable()->comment('json: order_cond; food_cond (array)');
			$table->text('promotion_extra_condition', 65535)->nullable()->comment('thiết lập theo số lần giảm giá hóa đơn theo KH');
			$table->boolean('promotion_subtype2_option')->nullable()->default(0)->comment('Hàng tặng không nhân theo số lượng mua');
			$table->dateTime('regdate')->nullable();
			$table->dateTime('lastupdate')->nullable();
			$table->boolean('invalid')->nullable()->default(0)->index('invalid');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('promotion');
	}

}

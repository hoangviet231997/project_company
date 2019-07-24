<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromotionDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promotion_detail', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('promotion_id')->nullable();
			$table->integer('food_id')->nullable();
			$table->string('food_name')->nullable();
			$table->float('amount', 11)->nullable()->default(0.00)->comment('so luong mon (truong hop tang mon)');
			$table->integer('food2_id')->nullable()->comment('trường hợp mua món tặng món');
			$table->string('food2_name')->nullable()->comment('trường hợp mua món tặng món');
			$table->float('amount2', 11)->nullable()->comment('trường hợp mua món tặng món');
			$table->float('amount_used', 11)->nullable()->default(0.00);
			$table->float('discount_type', 10, 0)->nullable()->default(0)->comment('0 : giam % 1 : giam truc tiep số tiền');
			$table->float('discount_value', 10, 0)->nullable()->comment('% 0.01  hoac so tien phu thuoc vao ');
			$table->float('change_price', 10, 0)->nullable()->comment('có thể tăng hoặc giảm phụ thuộc vào promotiontype = giam gia hay phụ thu');
			$table->boolean('is_category')->nullable()->default(0)->comment('nếu is_category = 1 thì food_id, food_name là menu_id và menu_name');
			$table->boolean('is_category2')->nullable()->default(0)->comment('nếu is_category2 = 1 thì food2_id, food2_name là menu2_id và menu2_name');
			$table->boolean('is_all')->nullable()->default(0);
			$table->boolean('is_all2')->nullable()->default(0);
			$table->dateTime('regdate')->nullable();
			$table->dateTime('lastupdate')->nullable();
			$table->boolean('invalid')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('promotion_detail');
	}

}

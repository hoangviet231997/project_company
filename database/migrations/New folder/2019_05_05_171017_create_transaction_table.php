<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->decimal('local_id', 22, 0)->nullable();
			$table->integer('version_code')->nullable();
			$table->string('code', 30)->nullable();
			$table->string('account_id', 30)->nullable();
			$table->string('account_name')->nullable();
			$table->integer('shop_id')->default(0);
			$table->integer('shift_id')->nullable();
			$table->boolean('auto_type')->nullable()->default(0)->comment('0: thu cong; 1: tu dong');
			$table->boolean('frequent_type')->nullable()->default(0)->comment('0: ko thuong xuyen; 1: thuong xuyen');
			$table->boolean('type')->nullable()->default(0)->comment('1: thu; 2: chi');
			$table->boolean('sub_type')->nullable()->default(0)->comment('1: tham chieu ,  2: phiếu chi do hủy hoa don ban hang , 3: phieu chi do huy phieu thu , 4: phieu thu do huy phieu chi');
			$table->integer('asset_id')->nullable();
			$table->string('asset_name')->nullable();
			$table->boolean('status')->nullable()->default(0)->comment('0: tam; 1: xong');
			$table->float('pre_amount', 11)->nullable()->comment('ton dau công nợ KH, NCC');
			$table->float('amount', 11)->nullable()->comment('amount = input_amount + surcharge+ feeship-discount');
			$table->float('debt_amount', 11)->nullable()->default(0.00)->comment('no còn lại chưa thanh toán của phiếu thu này');
			$table->float('after_amount', 11)->nullable()->comment('ton cuoi công no KH , NCC ');
			$table->float('input_amount', 11)->nullable()->comment('thu chi : amout = so tien nhap. Neu ban hang KH thieu no -> amount =  total - paid\'');
			$table->float('total', 11)->nullable()->comment('total doanh thu = amount + phu thu - giam gia + ship');
			$table->decimal('total_asset', 24)->nullable()->default(0.00)->comment('total quỹ tiền');
			$table->boolean('soure_type')->nullable()->default(0)->comment('1: từ order; 2: từ thu nơ KH ; 3: tra no nha cung cap; 4: inventory; 10: hủy thu order; 11: hủy thu khác; 12: hủy chi , 13 : chuyển ví');
			$table->decimal('soure_id', 22, 0)->nullable()->comment('souretype =1 -> soure id = order id; sourcetype = 2 -> source id = transaction_local_id (cong no -> tra no theo hoa don) ,  sourcetype = 4 -> source id = transaction inventory master id, souretype =13 -> soureid = gốc ví chuyển');
			$table->integer('whowith_id')->nullable();
			$table->string('whowith_name')->nullable();
			$table->integer('category')->nullable()->default(1)->comment('transaction category');
			$table->text('note', 65535)->nullable();
			$table->dateTime('regdate')->nullable();
			$table->dateTime('regdate_local')->nullable();
			$table->dateTime('update')->nullable();
			$table->dateTime('update_local')->nullable();
			$table->dateTime('printdate')->nullable();
			$table->dateTime('printdate_local')->nullable();
			$table->boolean('invalid')->nullable()->default(0);
			$table->boolean('customer_debt_flg')->nullable()->default(1)->comment('0: khong tinh phat sinh cong no khach hang   1: tinh thong ke phat sinh cong no khach hang');
			$table->integer('transaction_business_date')->nullable()->default(0);
			$table->float('transaction_balance', 11)->nullable()->default(0.00)->comment('tính công nợ trừ dần cho từng phiếu thu chi . Nếu =0 phiếu này đã hoàn tất tính vào công nợ KH');
			$table->text('transaction_refer_ids', 65535)->nullable();
			$table->float('transaction_surcharge', 11)->nullable()->default(0.00);
			$table->float('transaction_discount', 11)->nullable()->default(0.00);
			$table->float('transaction_fee_ship', 11)->nullable()->default(0.00);
			$table->boolean('revenueship_flg')->nullable()->default(0)->comment('0: không tính phí ship vào doanh thu; 1: tính phí ship vào doanh thu');
			$table->boolean('report_flg')->nullable()->default(1)->comment('cờ có tính trong doanh thu hay không');
			$table->integer('presave_transaction_id')->nullable()->default(0);
			$table->boolean('transaction_ignore')->nullable()->default(0)->comment('0: phieu thu, chi normal , 1: tinh doanh hoac chi phi khong phat quy tien');
			$table->boolean('is_open_shift')->nullable()->default(0);
			$table->boolean('is_deposit')->nullable()->default(0)->comment('transaction đặt cọc');
			$table->decimal('shift_local_id', 22, 0)->nullable()->default(0);
			$table->boolean('open_close_shift_type')->nullable()->default(0)->comment('0: bt; 1: open; 2: close');
		});

		DB::statement('ALTER TABLE `transaction` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `shop_id`) USING BTREE;');
		DB::statement('ALTER TABLE `transaction` ADD INDEX `shop_id` (`shop_id`) using BTREE;');
		DB::statement('ALTER TABLE `transaction` ADD INDEX `invalid` (`invalid`) using BTREE;');
		DB::statement('ALTER TABLE `transaction` ADD INDEX `transaction_business_date` (`transaction_business_date`) using BTREE;');
		DB::statement('ALTER TABLE `transaction` ADD INDEX `open_close_shift_type` (`open_close_shift_type`) using BTREE;');

		DB::statement('ALTER TABLE `transaction` PARTITION BY HASH(`shop_id`) PARTITIONS 50;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaction');
	}
}

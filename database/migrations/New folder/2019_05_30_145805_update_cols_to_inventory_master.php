<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColsToInventoryMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_master', function (Blueprint $table) {
            $table->string('batch_no', 100)->nullable()->comment('số lô')->after('product_extend_id');
            $table->date('batch_expire_date')->nullable()->comment('ngày hết hạn lô')->after('batch_no');
        });

		Schema::table('inventory_detail', function (Blueprint $table) {
			$table->string('batch_no', 100)->nullable()->comment('số lô')->after('product_extend_id');
			$table->date('batch_expire_date')->nullable()->comment('ngày hết hạn lô')->after('batch_no');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_master', function (Blueprint $table) {
            //
        });
    }
}

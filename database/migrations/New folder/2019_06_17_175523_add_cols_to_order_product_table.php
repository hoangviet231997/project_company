<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->tinyInteger('product_type')->nullable()->comment('1: hàng hóa; 2: dịch vụ; 3: combo; 100: web teamplate; 101: pos service');
			$table->integer('area_id')->nullable();
			$table->string('area_name')->nullable();
			$table->integer('table_id')->nullable();
			$table->string('table_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            //
        });
    }
}

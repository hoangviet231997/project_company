<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToProductMasterAndProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->tinyInteger('product_unit_type')->nullable()->comment('0: minute; 1: hour; 2 day')->after('primary_unit_name');
        });

		Schema::table('product', function (Blueprint $table) {
			$table->tinyInteger('product_unit_type')->nullable()->comment('0: minute; 1: hour; 2 day')->after('unit_name');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

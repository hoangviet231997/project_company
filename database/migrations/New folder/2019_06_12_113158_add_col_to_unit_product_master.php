<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToUnitProductMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_master', function (Blueprint $table) {
            $table->tinyInteger('unit_type')->default(0)->comment('0: all; 1: unit product; 2: unit service');
        });

        Schema::table('product_master', function (Blueprint $table) {
			$table->text('place_tag')->nullable()->comment('json encode table id');
		});

		Schema::table('product', function (Blueprint $table) {
			$table->text('place_tag')->nullable()->comment('json encode table id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_master', function (Blueprint $table) {
            //
        });
    }
}

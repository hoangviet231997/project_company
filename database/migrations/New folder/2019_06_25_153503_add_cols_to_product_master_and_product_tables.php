<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToProductMasterAndProductTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_master', function (Blueprint $table) {
            $table->integer('supplier_id')->nullable();
            $table->string('supplier_name', 255)->nullable();
        });

        Schema::table('product', function (Blueprint $table) {
            $table->integer('supplier_id')->nullable();
            $table->string('supplier_name', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_master', function (Blueprint $table) {
            //
        });

        Schema::table('product', function (Blueprint $table) {
            
        });
    }
}

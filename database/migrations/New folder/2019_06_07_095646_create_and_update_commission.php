<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAndUpdateCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_supplier_group', function (Blueprint $table) {
            DB::statement('ALTER TABLE customer_supplier_group ADD COLUMN account_flg TINYINT(4) DEFAULT 0');
        });

        Schema::create('commission_master', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_supplier_group_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('product_amount')->nullable();
            $table->double('commission_percent', 11, 3)->nullable();

        });

        Schema::create('account_commission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->nullable();
            $table->integer('commission_id')->nullable();
            
        });

        Schema::create('dealer_commission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id')->nullable();
            $table->integer('commission_id')->nullable();
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_supplier_group', function (Blueprint $table) {

        });
        Schema::dropIfExists('commission_master');
        Schema::dropIfExists('account_commission');
        Schema::dropIfExists('dealer_commission');
    }
}

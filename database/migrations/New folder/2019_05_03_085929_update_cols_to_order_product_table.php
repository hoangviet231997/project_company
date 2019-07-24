<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColsToOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
        	$table->dropIndex('order_item_menu_name');
        	$table->dropUnique('order_item_local');
        	$table->renameColumn('order_item_local_id', 'order_product_local_id');
        	$table->renameColumn('order_item_version_code', 'order_product_version_code');
        	$table->renameColumn('order_item_account_id', 'order_product_account_id');
        	$table->renameColumn('order_item_account_name', 'order_product_account_name');
        	$table->renameColumn('order_item_category_id', 'order_product_category_id');
        	$table->renameColumn('order_item_category_name', 'order_product_category_name');
        	$table->renameColumn('order_item_parent_id', 'order_product_parent_id');
        	$table->index('order_product_category_name', 'order_product_category_name');
        	$table->index('order_product_local_id', 'order_product_local_id');
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

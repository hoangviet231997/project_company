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
            $table->float('discount_price')->comment('')->change();
            $table->renameColumn('discount_price_val', 'discount_percent');
            $table->renameColumn('order_item_regdate_local_date', 'regdate_local');
            $table->renameColumn('last_update_date', 'last_update');
            $table->renameColumn('order_item_update_local_date', 'last_update_local');
            $table->renameColumn('order_item_print_local_date', 'print_date_local');
            $table->renameColumn('nameSortOrderFood', 'name_sort_order_food');
            $table->renameColumn('orderIndexOrderFood', 'order_index_order_food');
            $table->renameColumn('promotiondetail_id', 'promotion_detail_id');
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

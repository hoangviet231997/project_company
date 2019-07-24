<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastInputPriceToInventoryTransactionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_transaction_log', function (Blueprint $table) {
            $table->double('last_input_price', 11, 3)->default(null)->comment('Giá nhập cuối');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_transaction_log', function (Blueprint $table) {
            //
        });
    }
}

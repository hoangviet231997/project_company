<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToInventoryTransactionMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_transaction_master', function (Blueprint $table) {
            $table->decimal('source_id2', 22, 0)->default(0)->comment('map id transaction master receive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_transaction_master', function (Blueprint $table) {
            //
        });
    }
}

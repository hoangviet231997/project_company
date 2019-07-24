<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentStatusToInventoryTransactionMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_transaction_master', function (Blueprint $table) {
            $table->tinyInteger('payment_status')
                ->default(0)
                ->comment('1: đã thanh toán, 2: thanh toán 1 phần, 3: chưa thanh toán');
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

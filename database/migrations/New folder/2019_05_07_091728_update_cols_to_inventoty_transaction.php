<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColsToInventotyTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_transaction', function (Blueprint $table) {
            $table->decimal('id', 22, 0)->change();
            $table->decimal('transaction_masterid', 22, 0)->change();
            $table->dropColumn(['local_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_transaction', function (Blueprint $table) {
            //
        });
    }
}

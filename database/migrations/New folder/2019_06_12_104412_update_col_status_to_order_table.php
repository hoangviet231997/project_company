<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColStatusToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `order` MODIFY COLUMN status TINYINT(4) COMMENT 'NEW = 0, IN_PROCESS = 1, WRAP = 2, DELIVERY = 3, COMPLETED = 4, CANCEL = 5, MERGED = 8, CHECKIN = 10, CHECKOUT = 11;'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}

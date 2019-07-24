<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentColPaymentStatusToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement("ALTER TABLE `order` MODIFY COLUMN payment_status TINYINT(4) COMMENT '0: chưa thanh toán; 1: thanh toán hoàn toàn; 2: thanh toán 1 phần'");
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

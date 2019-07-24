<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderTableAndAddOrderTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `order` MODIFY COLUMN status TINYINT(4) COMMENT 'NEW = 0, IN_PROCESS = 1, WRAP = 2, DELIVERY = 3, COMPLETED = 4, CANCEL = 5, MERGED = 8, CHECKIN = 10, CHECKOUT = 11; ORDER_BOOKING = 12'");
        
        Schema::table('order', function (Blueprint $table) {
            $table->dateTime('booking_time')->nullable()->after('last_update_local');
            $table->dateTime('checkin_time')->nullable()->after('last_update_local');
            $table->dateTime('checkout_time')->nullable()->after('last_update_local');
            $table->string('type_name', 255)->nullable()->after('type');
        });

        Schema::create('order_type_master', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id');
            $table->string('order_type', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('regdate', 255)->nullable();
            $table->tinyInteger('invalid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

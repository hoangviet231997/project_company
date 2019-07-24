<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySortOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('order', function (Blueprint $table) {
			$table->dropColumn('booking_time');
			$table->dropColumn('checkin_time');
			$table->dropColumn('checkout_time');
		});

    	Schema::table('order', function (Blueprint $table) {
			$table->dateTime('booking_time')->nullable()->after('last_update_local');
			$table->dateTime('checkin_time')->nullable()->after('booking_time');
			$table->dateTime('checkout_time')->nullable()->after('checkin_time');
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

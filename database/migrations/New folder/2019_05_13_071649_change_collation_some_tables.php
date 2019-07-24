<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeCollationSomeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::statement('alter table `asset_amount_log` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `migrations` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `promotion` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `promotion_detail` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `transaction` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `user_shop` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `account` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `order` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `order_product` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `product` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `product_category` convert to character set utf8 collate utf8_general_ci;');
        DB::statement('alter table `product_master` convert to character set utf8 collate utf8_general_ci;');
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

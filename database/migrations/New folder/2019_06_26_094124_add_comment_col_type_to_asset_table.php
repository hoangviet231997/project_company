<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentColTypeToAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement(<<<EOD
alter table `asset` 
modify column type tinyint(4) 
comment '0: tk tiền mặt; 1: tk ngân hàng mặc định; 2: tk ngân hàng; 3: tk điểm; 4: tk sử dụng dịch vụ'
EOD
);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset', function (Blueprint $table) {
            //
        });
    }
}

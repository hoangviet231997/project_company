<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertBoard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_board', function (Blueprint $table) {
            $table->increments('id')->length(11);
            $table->text('shop_ids')->nullable(false)->comment("0: cho toàn bộ đại lý, KH của shop tạo thông báo; shop_ids phân cách bởi dấu ,',");
            $table->integer('created_shop_id')->length(11)->nullable(false);
            $table->tinyInteger('type')->length(4)->nullable()->comment("loại cảnh báo 1: Hệ thống 2: Giới thiệu khách hàng 3: Khuyến mãi 4: Cảnh báo tồn kho");
            $table->string('title',200)->nullable();
            $table->string('title_color',20)->nullable();
            $table->text('message')->nullable();
            $table->string('detail_url',500)->nullable();
            $table->string('sub_url',500)->nullable()->comment("khuyến mãi thì đẩy url thể lệ chương trình");
            $table->string('img_url',500)->nullable();
            $table->tinyInteger('popup_flg')->default(0)->comment("0: not poup 1: popup");
            $table->dateTime('regdate')->nullable();
            $table->dateTime('updatedate')->nullable();
            $table->tinyInteger('invalid')->length(4)->nullable();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alert_board');
    }
}

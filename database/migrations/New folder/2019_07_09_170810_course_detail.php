<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourseDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('course_detail', function (Blueprint $table) {
            $table->increments('id',11);
            $table->string('name',255);
            $table->integer('product_id')->length(11)->unsigned()->nullable();
            $table->tinyInteger('type')->length(4)->default(0)->comment('0: tại salon, 1: tại nhà hàng ngày, 2: tại nhà hàng tuần');
            $table->integer('parent_course_id')->length(11)->default(0)->comment('0: parent course');
            $table->tinyInteger('index_sort')->length(4)->default(0);
            $table->integer('shop_id')->length(11)->unsigned()->nullable();
            $table->tinyInteger('invalid')->length(4)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_detail');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourseMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image',255)->nullable();
            $table->string('name',255);
            $table->text('description')->nullable();
            $table->integer('shop_id')->length(11)->nullable();
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
        Schema::drop('course_master');
    }
}

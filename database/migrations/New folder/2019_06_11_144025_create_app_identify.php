<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppIdentify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('app_identify', function (Blueprint $table) {
			$table->increments('id');
			$table->string('app_id', 32)->nullable();
			$table->string('secret_token', 64)->nullable();
			$table->string('callback_url')->nullable();
			$table->string('access_token', 64)->nullable();
			$table->tinyInteger('type')->default(0)->comment('1: user app; 2: web app');
			$table->dateTime('expire_date')->nullable();
			$table->timestamps();
			$table->boolean('invalid')->default(0);
		});

		Schema::create('app_shop', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('app_identify_id');
			$table->integer('shop_id')->nullable();
			$table->string('shop_name')->nullable();
			$table->integer('role_permission_id')->nullable();
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
        Schema::dropIfExists('app_identify');
    }
}

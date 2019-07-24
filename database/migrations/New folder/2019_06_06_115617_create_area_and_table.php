<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaAndTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('shop_id')->nullable();
            $table->timestamps();
        });

		Schema::create('table', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->integer('area_id')->nullable();
			$table->integer('shop_id')->nullable();
			$table->boolean('available')->default(1);
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
    }
}

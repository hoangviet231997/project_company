<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColSidebarTextColorToShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('shop', function (Blueprint $table) {
			$table->string('sidebar_text_color')->default('white')->after('sidebar_color');
			$table->string('sidebar_text_selected_color')->default('white')->after('sidebar_text_color');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop', function (Blueprint $table) {
            //
        });
    }
}

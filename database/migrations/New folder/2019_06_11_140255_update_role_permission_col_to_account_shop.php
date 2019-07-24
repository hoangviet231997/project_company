<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRolePermissionColToAccountShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account', function (Blueprint $table) {
            $table->dropColumn('role_permission_id');
        });
        Schema::table('account_shop', function (Blueprint $table) {
            $table->integer('role_permission_id')->nullable()->after('shop_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account', function (Blueprint $table) {

        });
        Schema::table('account_shop', function (Blueprint $table) {

        });
    }
}

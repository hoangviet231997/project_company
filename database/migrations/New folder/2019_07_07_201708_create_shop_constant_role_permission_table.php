<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopConstantRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_constant_role_permission', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('shop_id');
            $table->longText('role_permission');
            $table->tinyInteger('invalid')->default(0)->comment('0:active, 1:deActive');
            $table->integer('parent_shop_role_permission_id')->default(0)->comment('Map to role_permission with id');
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
        Schema::dropIfExists('shop_constant_role_permission');
    }
}

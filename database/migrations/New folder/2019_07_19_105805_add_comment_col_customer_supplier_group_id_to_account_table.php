<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentColCustomerSupplierGroupIdToAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('account', function (Blueprint $table) {
			$table->integer('customer_supplier_group_id')->nullable()->comment('chỉ lưu trong trường hợp là nhóm nhân viên, nếu nhóm KH thì vẫn lưu trong table customer_supplier như cũ')->change();
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
            //
        });
    }
}

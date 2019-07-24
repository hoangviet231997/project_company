<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommentColsInventoryTransactionMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_transaction_master', function (Blueprint $table) {
            $comment  =<<<EOD
1: Nhập
	1: mua
	2: nhập hủy HD,
	3: nhập nội bộ
	4: nhập chuyển
	5: nhập tồn
	7: khách hàng trả lại
	8: nhập từ nhà cung cấp
2: Xuất
	1: do bán hàng
	2: xuất trả hàng
	3: xuat nội bộ
	4: xuất chuyển
	5: xuất hủy
	6: xuất định lượng bán hàng
	8: xuất trả nhà cung cấp
3: Kiểm kho
4: Phiếu cấp phát
EOD;

            $table->integer('sub_type')->comment($comment)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_tranasction_master', function (Blueprint $table) {
            //
        });
    }
}

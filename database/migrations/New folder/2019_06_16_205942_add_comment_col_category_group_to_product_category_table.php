<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentColCategoryGroupToProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_category', function (Blueprint $table) {
            $table->smallInteger('category_group')->nullable()->comment('product type: 0: Dược phẩm; 1: Vật tư y tế; 2: Hàng hóa khác; 3: Hàng hoá; 4: Dịch vụ; 5: Gói dịch vụ; 6: Khác')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_category', function (Blueprint $table) {
            //
        });
    }
}

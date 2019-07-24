<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableCommissionMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_master', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->text('note')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->tinyInteger('invalid')->default(0);
            $table->dropColumn('product_id');
            $table->dropColumn('product_amount');
            $table->dropColumn('commission_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_master', function (Blueprint $table) {
            //
        });
    }
}

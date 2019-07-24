<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsCustomerSupplierGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_supplier_group', function (Blueprint $table) {
            $table->tinyInteger('is_default_customer_agency_register')->length(4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_supplier_group', function (Blueprint $table) {
            //
        });
    }
}

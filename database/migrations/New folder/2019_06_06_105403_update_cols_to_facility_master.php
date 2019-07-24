<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColsToFacilityMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_master', function (Blueprint $table) {
            //
            DB::statement('ALTER TABLE facility_master MODIFY COLUMN facility_name VARCHAR(255)');
            DB::statement('ALTER TABLE facility_master MODIFY COLUMN facility_adress VARCHAR(255)');
            DB::statement('ALTER TABLE facility_master MODIFY COLUMN regdate VARCHAR(255)');
            DB::statement('ALTER TABLE facility_master MODIFY COLUMN invalid TINYINT DEFAULT 0 NOT NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_master', function (Blueprint $table) {
            //
        });
    }
}

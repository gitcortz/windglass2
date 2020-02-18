<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimesheetdetailsTableAddstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timesheet_details', function (Blueprint $table) {
            $table->integer('status_id')->nullable()->unsigned();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timesheet_details', function (Blueprint $table) {
            $table->dropColumn(['status_id']);
        });
    }
}

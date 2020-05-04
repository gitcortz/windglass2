<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTableAudituser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->biginteger('createdby_id')->nullable()->unsigned();  
            $table->foreign('createdby_id')->references('id')->on('users');
            $table->biginteger('lastupdatedby_id')->nullable()->unsigned();  
            $table->foreign('lastupdatedby_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['createdby_id']);
            $table->dropColumn(['lastupdatedby_id']);
        });
    }
}

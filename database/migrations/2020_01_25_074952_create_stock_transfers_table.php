<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('from_branch_id')->nullable()->unsigned();  
            $table->foreign('from_branch_id')->references('id')->on('branches');
            $table->biginteger('to_branch_id')->nullable()->unsigned();  
            $table->foreign('to_branch_id')->references('id')->on('branches');
            $table->dateTime('scheduled_date')->nullable();
            $table->dateTime('received_date')->nullable();
            $table->integer('transfer_status_id')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_transfers');
    }
}

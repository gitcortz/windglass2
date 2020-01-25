<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransferItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfer_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('stock_transfer_id')->unsigned();  
            $table->foreign('stock_transfer_id')->references('id')->on('stock_transfers');
            $table->biginteger('stock_id')->unsigned();  
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->decimal('quantity', 9, 2)->nullable();
            $table->decimal('actual', 9, 2)->nullable();
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
        Schema::dropIfExists('stock_transfer_items');
    }
}

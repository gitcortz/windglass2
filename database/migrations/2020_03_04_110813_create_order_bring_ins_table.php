<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBringInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_bring_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('order_id')->unsigned();  
            $table->foreign('order_id')->references('id')->on('orders');  
            $table->biginteger('stock_id')->unsigned();  
            $table->foreign('stock_id')->references('id')->on('stocks');  
            $table->integer('quantity');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_bring_ins');
    }
}

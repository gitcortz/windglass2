<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('stock_id')->unsigned();  
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->biginteger('from_id')->nullable()->unsigned();  
            $table->biginteger('to_id')->nullable()->unsigned();  
            $table->integer('movement_type')->nullable();
            $table->decimal('quantity', 9, 2)->nullable();
            $table->decimal('quantity_before', 9, 2)->nullable();            
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
        Schema::dropIfExists('stock_movements');
    }
}

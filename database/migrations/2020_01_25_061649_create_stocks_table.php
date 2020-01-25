<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('branch_id')->nullable()->unsigned();  
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->biginteger('product_id')->nullable()->unsigned();  
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('initial_stock', 9, 2)->nullable();
            $table->decimal('current_stock', 9, 2)->nullable();
            $table->integer('stock_status_id')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}

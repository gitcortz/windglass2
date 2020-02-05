<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('order_date');
            $table->dateTime('delivered_date')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('notes')->nullable();
            $table->integer('order_status_id')->nullable();
            $table->integer('payment_status_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->biginteger('customer_id')->unsigned();  
            $table->foreign('customer_id')->references('id')->on('customers'); 
            $table->biginteger('branch_id')->nullable()->unsigned();  
            $table->foreign('branch_id')->references('id')->on('branches');      
            $table->decimal('discount', 9, 2)->nullable();
            $table->decimal('sub_total', 9, 2)->nullable();

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
        Schema::dropIfExists('orders');
    }
}

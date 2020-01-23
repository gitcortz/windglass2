<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->biginteger('producttype_id')->nullable()->unsigned();  
            $table->foreign('producttype_id')->references('id')->on('product_types');
            $table->biginteger('brand_id')->nullable()->unsigned();  
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->decimal('unit_price', 9, 2);

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
        Schema::dropIfExists('products');
    }
}

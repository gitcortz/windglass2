<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_loans', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->biginteger('employee_id')->unsigned();  
            $table->foreign('employee_id')->references('id')->on('employees');            
            $table->decimal('loan_amount', 9, 2)->nullable();
            $table->integer('loan_status_id');       
            $table->integer('loan_type_id');            
            $table->decimal('balance', 9, 2)->nullable();

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
        Schema::dropIfExists('employee_loans');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLoanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_loan_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('employee_id')->nullable()->unsigned();  
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->biginteger('employee_loan_id')->nullable()->unsigned();  
            $table->foreign('employee_loan_id')->references('id')->on('employee_loans');        
            $table->decimal('before_amount', 9, 2)->nullable();
            $table->decimal('after_amount', 9, 2)->nullable();
            $table->integer('loan_transaction_type')->nullable();
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
        Schema::dropIfExists('employee_loan_transactions');
    }
}

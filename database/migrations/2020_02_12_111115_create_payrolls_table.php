<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('employee_id')->nullable()->unsigned();  
            $table->foreign('employee_id')->references('id')->on('employees'); 
            $table->integer('year');
            $table->integer('week_no');
            $table->decimal('monday', 9, 2)->nullable();
            $table->decimal('tuesday', 9, 2)->nullable();
            $table->decimal('wednesday', 9, 2)->nullable();
            $table->decimal('thursday', 9, 2)->nullable();
            $table->decimal('friday', 9, 2)->nullable();
            $table->decimal('saturday', 9, 2)->nullable();
            $table->decimal('sunday', 9, 2)->nullable();
            $table->decimal('monday_late', 9, 2)->nullable();
            $table->decimal('tuesday_late', 9, 2)->nullable();
            $table->decimal('wednesday_late', 9, 2)->nullable();
            $table->decimal('thursday_late', 9, 2)->nullable();
            $table->decimal('friday_late', 9, 2)->nullable();
            $table->decimal('saturday_late', 9, 2)->nullable();
            $table->decimal('sunday_late', 9, 2)->nullable();
            $table->decimal('total_lates', 9, 2)->nullable();
            $table->decimal('day_rate', 9, 2)->nullable();
            $table->integer('total_days');
            $table->decimal('total_hours', 9, 2)->nullable();            
            $table->decimal('total', 9, 2)->nullable();
            $table->decimal('total_loans', 9, 2)->nullable();
            $table->decimal('vale_payment', 9, 2)->nullable();
            $table->decimal('loan_payment', 9, 2)->nullable();
            $table->decimal('total_ot_amount', 9, 2)->nullable();
            $table->decimal('total_ot_hours', 9, 2)->nullable(); 
            $table->decimal('loan_balance', 9, 2)->nullable();
            $table->decimal('grand_total', 9, 2)->nullable();
            $table->integer('payroll_status');

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
        Schema::dropIfExists('payrolls');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePayrollsTableAddLoanId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->biginteger('vale_loan_id')->nullable()->unsigned();  
            $table->biginteger('sss_loan_id')->nullable()->unsigned();  
            $table->biginteger('salary_loan_id')->nullable()->unsigned();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn(['vale_loan_id']);
            $table->dropColumn(['sss_loan_id']);
            $table->dropColumn(['salary_loan_id']);
        });
    }
}

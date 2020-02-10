<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->biginteger('city_id')->nullable()->unsigned();  
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('hire_date')->nullable();
            $table->decimal('base_salary', 9, 2)->nullable();
            $table->string('biometrics_id')->nullable();
            $table->biginteger('employeetype_id')->unsigned()->nullable();  
            $table->foreign('employeetype_id')->references('id')->on('employee_types');
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
        Schema::dropIfExists('employees');
    }
}

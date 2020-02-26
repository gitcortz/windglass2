<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user_id')->nullable()->unsigned();  
            $table->foreign('user_id')->references('id')->on('users');  
            $table->biginteger('branch_id')->nullable()->unsigned();  
            $table->foreign('branch_id')->references('id')->on('branches');  
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
        Schema::dropIfExists('user_branches');
    }
}

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
            $table->increments('id');
            $table->integer('user_id');
            $table->string('employee_no');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->string('birthdate');
            $table->string('date_hired');
            $table->string('position_id');
            $table->string('department_id');
            $table->string('branch_id');
            $table->string('civil_status');
            $table->string('contact_1');
            $table->string('contact_2');
            $table->mediumText('present_address');
            $table->mediumText('permanent_address');
            $table->string('skype');
            $table->string('tin');
            $table->string('sss');
            $table->string('hdmf');
            $table->string('phic');
            $table->string('profile_picture');
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
        Schema::dropIfExists('employees');
    }
}

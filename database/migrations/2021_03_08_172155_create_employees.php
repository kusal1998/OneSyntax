<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees', function (Blueprint $table) {
            $table->id();
            $table->string('frstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('address');
            $table->string('department_id');
            $table->string('city_id');
            $table->string('state_id');
            $table->string('country_id');
            $table->string('zip');
            $table->date('birthdate');
            $table->date('date_hired');
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
        Schema::dropIfExists('tbl_employees');
    }
}

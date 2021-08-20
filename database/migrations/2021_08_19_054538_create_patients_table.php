<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('doctor_id')->unsigned();
			$table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name');
			$table->string('last_name');
			$table->date('dob');
			$table->text('image');
            $table->bigInteger('hospital_id')->unsigned();
			$table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->bigInteger('specialist_id')->unsigned();
			$table->foreign('specialist_id')->references('id')->on('specialities')->onDelete('cascade');
			$table->date('admission_date');
			$table->enum('admission_status',['1','2']);
			$table->date('date_of_schedule');
			$table->string('refer_doctor_name');
			$table->date('referral_date');
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
        Schema::dropIfExists('patients');
    }
}

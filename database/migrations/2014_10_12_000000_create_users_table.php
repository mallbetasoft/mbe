<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
			$table->enum('role', ['admin','doctor','patient'])->default('admin');
            $table->string('name');
			$table->string('last_name');
			$table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
			$table->date('dob');
			$table->text('image');
			$table->integer('hospital_id');
			$table->integer('specialist_id');
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
        Schema::dropIfExists('users');
    }
}

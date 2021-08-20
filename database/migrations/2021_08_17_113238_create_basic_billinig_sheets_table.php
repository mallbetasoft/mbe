<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicBillinigSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_billinig_sheets', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('comments');
			$table->string('billing_sheet_file');
            $table->timestamps();
			$table->bigInteger('doctor_id')->unsigned();
			$table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_billinig_sheets');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->string('contract_id')->unique();
            $table->string('durations');
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->integer('repayment_frequency');
            $table->integer('user_id');
            $table->integer('arrangement_fee');
            $table->float('interest_rate');

            $table->float('total');
            $table->float('need_to_pay');
            $table->timestamps();

            $table->index(["user_id", "contract_id"]);
            $table->index(["contract_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("loans");
    }
}

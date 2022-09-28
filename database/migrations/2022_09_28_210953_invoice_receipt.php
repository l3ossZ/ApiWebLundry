<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_receipt',function(Blueprint $table){
            $table->id();
            $table->timestamp('timestamp');
            $table->string('EMP_name');
            $table->string('CS_id');
            $table->string('CS_name');
            $table->string('CS_ADS')->nullable();
            $table->date('pick_date')->nullable();
            $table->string('pick_time')->nullable();
            $table->date('deli_date')->nullable();
            $table->string('deli_time')->nullable();
            $table->boolean('is_membership_or');
            $table->double('pick_ser_charge')->nullable();
            $table->double('deli_ser_charge')->nullable();
            $table->string('deli_EMP')->nullable();
            $table->double('total');
            $table->string('pay_method')->nullable();

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
        Schema::dropIfExists('invoice_receipt');
    }
};

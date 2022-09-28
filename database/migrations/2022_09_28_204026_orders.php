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
        Schema::create('orders',function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->string('service');
            $table->date('pick_date')->nullable();
            $table->string('pick_time')->nullable();
            $table->date('deli_date')->nullable();
            $table->string('deli_time')->nullable();
            $table->string('pick_ADS');
            $table->string('deli_ADS');
            $table->string('respond_EMP');
            $table->timestamp('deli_EMP')->nullable();
            $table->boolean('pay_status');
            $table->string('pay_method');
            $table->double('pick_ser_charge')->nullable();
            $table->double('deli_ser_charge')->nullable();
            $table->double('total');
            $table->string('status');
            $table->boolean('is_membership_or');

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
        Schema::dropIfExists('orders');
    }
};

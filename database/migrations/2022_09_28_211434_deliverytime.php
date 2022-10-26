<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('delivery_times',function(Blueprint $table){
            $table->id();
            $table->date('date');
            $table->string('time') ;
            $table->string('orderName')->default("");
            $table->string('job');
            $table->integer('numOfWork')->default(3);
            $table->integer('currentOrderWork')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('delivery_times');
    }
};

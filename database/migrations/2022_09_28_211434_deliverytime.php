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
            $table->string('orderId') ;
            $table->string('job');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('delivery-time');
    }
};

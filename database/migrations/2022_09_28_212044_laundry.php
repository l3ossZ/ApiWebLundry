<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('laundry',function(Blueprint $table){
            $table->id();
            $table->string('name') ;
            $table->string('phone') ;
            $table->string('owner') ;
            $table->string('email') ;
            $table->string('address');
            $table->string('lineId') ;
            $table->time('opentime') ;
            $table->time('closetime') ;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laundry');
    }
};

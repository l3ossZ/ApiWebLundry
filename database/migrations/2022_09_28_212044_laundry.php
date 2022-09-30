<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('laundries',function(Blueprint $table){
            $table->id();
            $table->string('name') ;
            $table->string('phone')->unique() ;
            $table->string('owner') ;
            $table->string('email')->unique() ;
            $table->string('address');
            $table->string('lineId') ;
            $table->string('opentime') ;
            $table->string('closetime') ;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laundries');
    }
};

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
            $table->string('name')->unique() ;
            $table->string('phone')->unique() ;
            $table->string('owner') ;
            $table->string('email')->unique() ;
            $table->string('email_pwd');
            $table->string('address')->unique()->nullable()->default("-");
            $table->string('lineId')->nullable() ;
            $table->string('workDay')->default("0111111") ;
            $table->string('opentime')->default("09:00") ;
            $table->string('closetime')->default("19:00") ;
            $table->double('numOfWork')->default(3);
            $table->string('status')->default("close");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laundries');
    }
};
